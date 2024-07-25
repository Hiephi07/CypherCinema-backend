<?php

namespace App\Services\Showtime;

use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Showtime\ShowtimeRepositoryInterface;
use Carbon\Carbon;
use Exception;

class ShowtimeService
{
    protected $movieRepository;
    protected $showtimeRepository;

    public function __construct(
        MovieRepositoryInterface $movieRepository,
        ShowtimeRepositoryInterface $showtimeRepository
    ) {
        $this->movieRepository = $movieRepository;
        $this->showtimeRepository = $showtimeRepository;
    }

    public function getMovieShowtimes($movieId, $dateString)
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', Carbon::parse($dateString)->format('Y-m-d'));

            $nowDate = Carbon::now()->toDateString();
            $nowTime = Carbon::now()->toTimeString();

            $movie = $this->movieRepository->findById($movieId, ['language', 'format']);

            $showtimes = $this->showtimeRepository->findByMovieAndDate($movieId, $date, $nowDate, $nowTime);

            $data = $showtimes->groupBy(function ($item) {
                return $item->room->theater->id;
            })
            ->map(function ($sessions, $cinemaID) use ($movie) {
                $theater = $sessions->first()->room->theater;
                return [
                    'title' => $theater->name,
                    'address' => $theater->address,
                    'cinemaID' => $cinemaID,
                    'sessions' => $sessions->map(function ($showtime) use ($movie) {
                        return [
                            'showtimeID' => $showtime->id,
                            'time' => $showtime->time_start,
                            'date' => $showtime->date,
                            'language' => $movie->language->name,
                            'format' => $movie->format->name
                        ];
                    }),
                ];
            })->values();
            return $data;
        } catch (Exception $e) {
            throw new Exception('Lỗi lấy khi lấy showtime: ' . $e->getMessage());
        }
    }
}
