<?php

namespace App\Repositories\Showtime;

interface ShowtimeRepositoryInterface {
    public function findByMovieAndDate($movieId, $date, $nowDate, $nowTime);
}