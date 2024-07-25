<?php

namespace App\Repositories\Seat;

use App\Models\Seat;
use App\Models\Showtime;
use Exception;

class SeatRepository implements SeatRepositoryInterface
{
    protected $seat;

    public function __construct(Seat $seat)
    {
        $this->seat = $seat;
    }

    public function getSeatsByShowtime($showtimeID)
    {
        try {
            return $this->seat->whereHas('room.showtimes', function($query) use ($showtimeID) {
                $query->where('id', $showtimeID);
            })->with('room.theater')->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi không thể lấy danh sách ghế: ' . $e->getMessage());
        }

    }
}
