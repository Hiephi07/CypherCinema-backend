<?php 

namespace App\Repositories\Showtime;

use App\Models\Showtime;
use Exception;

class ShowtimeRepository implements ShowtimeRepositoryInterface{
    protected $showtime;

    public function __construct(Showtime $showtime)
    {
        $this->showtime = $showtime;
    }

    public function findByMovieAndDate($movieId, $date, $nowDate, $nowTime)
    {
        try {
            return $this->showtime->where('movie_id', $movieId)
            ->with(['room.theater'])
            ->where(function ($query) use ($date, $nowDate, $nowTime) {
                if ($date->isSameDay($nowDate)) {
                    $query->where('time_start', '>', $nowTime);
                }
                $query->whereDate('date', $date);
            })
            ->orderBy('time_start')
            ->get();
        } catch (Exception $e) {
            throw new  Exception('Không tìm thấy showtime. ' . $e->getMessage());
        }
    }
}