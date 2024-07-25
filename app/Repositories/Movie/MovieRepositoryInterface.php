<?php

namespace App\Repositories\Movie;

interface MovieRepositoryInterface {
    public function getAll(array $relationship);
    public function getShowingMovies($filterShowtime, array $relationship);
    public function getUpcomingMovies(array $relationship);
    public function findById($id, array $relationship);
}