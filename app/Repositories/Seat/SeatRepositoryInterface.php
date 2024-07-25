<?php 

namespace App\Repositories\Seat;

interface SeatRepositoryInterface {
    public function getSeatsByShowtime($showtimeID);
}
