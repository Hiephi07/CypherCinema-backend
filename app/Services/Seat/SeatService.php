<?php

namespace App\Services\Seat;

use App\Repositories\Movie\MovieRepositoryInterface;
use App\Repositories\Seat\SeatRepositoryInterface;
use Exception;

class SeatService
{
    protected $seatRepository;
    protected $movieRepository;

    public function __construct(
        SeatRepositoryInterface $seatRepository,
        MovieRepositoryInterface $movieRepository
    )
    {
        $this->seatRepository = $seatRepository;
        $this->movieRepository = $movieRepository;
    }

    public function getSeatsByShowtime($showtimeID, $movieId)
    {
        try {
            $seats = $this->seatRepository->getSeatsByShowtime($showtimeID);
            $movie = $this->movieRepository->findById($movieId, ['classify', 'language', 'format']);
            $seatsByRows = $seats->groupBy('row')
                ->map(function ($seats, $rowName) {
                    return [
                        'name' => $rowName,
                        'cols' => $seats->map(function ($seat) {
                            return [
                                'seatID' => $seat->id,
                                'col' => $seat->col,
                                'price' => $seat->price,
                                'type' => $seat->seat_type_id,
                                'status' => $seat->status,
                            ];
                        })
                    ];
                })->values();

            return [
                'cinema' => [
                    'name' => $seats->first()->room->theater->name,
                    'address' => $seats->first()->room->theater->address
                ],
                'room' => [
                    'id' => $seats->first()->room->id,
                    'name' => $seats->first()->room->name,
                    'totalSeats' => $seats->count()
                ],
                'seats' => [
                    'row' => $seatsByRows
                ],
                'movie' => [
                    'name' => $movie->name,
                    'classify' => $movie->classify->name,
                    'language' => $movie->language->name,
                    'format' => $movie->format->name
                ],
                'showtime' => [
                    'day' => $seats->first()->room->showtimes->firstWhere('id', $showtimeID)->date,
                    'time' => $seats->first()->room->showtimes->firstWhere('id', $showtimeID)->time_start
                ]
            ];
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách ghế theo showtime: ' . $e->getMessage());
        }
    }
}
