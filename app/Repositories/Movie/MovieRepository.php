<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use Carbon\Carbon;
use Exception;

class MovieRepository implements MovieRepositoryInterface {
    protected $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function findById($id, array $relationship = [])
    {
        try {
            return $this->movie->with($relationship)->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy Movie: ' . $e->getMessage());
        }
    }

    public function getAll($relationship)
    {
        try {
            return $this->movie->with($relationship)->orderBy('premiere')->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả Movie: ' . $e->getMessage());
        }
    }

    public function getShowingMovies($filterShowtime, $relationship)
    {
        try {
            return $this->movie->with(array_merge($relationship, ['showtimes' => $filterShowtime]))
            ->whereHas('showtimes', $filterShowtime)
            ->orderBy('premiere')
            ->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả Movie đang chiếu: ' . $e->getMessage());
        }
    }

    public function getUpcomingMovies($relationship)
    {
        try {
            return $this->movie->with($relationship)
            ->where('premiere', '>', Carbon::now()->toDateTimeString())
            ->whereDoesntHave('showtimes')
            ->orderBy('premiere')
            ->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả Movie sắp chiếu: ' . $e->getMessage());
        }
    }
}