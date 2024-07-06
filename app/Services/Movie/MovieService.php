<?php 

namespace App\Services\Movie;

use App\Repositories\Movie\MovieRepositoryInterface;
use Carbon\Carbon;
use Exception;

class MovieService {
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function listMovie($state = null) {
        try {
            $nowDate = Carbon::now()->toDateString();
            $nowTime = Carbon::now()->toTimeString();
    
            $filterShowtime = function ($query) use ($nowDate, $nowTime) {
                $query->where('date', '>', $nowDate)
                    ->orWhere(function($query) use ($nowDate, $nowTime) {
                        $query->where('date', '=', $nowDate)
                            ->where('time_start', '>', $nowTime);
                    });
            };
    
            if (!empty($state)) {
                return ($state == 'showing') 
                    ? $this->movieRepository->getShowingMovies($filterShowtime, ['classify', 'language', 'format', 'category'])
                    : $this->movieRepository->getUpcomingMovies(['classify', 'language', 'format', 'category', 'showtimes']);
            } else {
                return $this->movieRepository->getAll(['classify', 'language', 'format', 'category', 'showtimes']);
            }
        } catch (Exception $e) {
            throw new Exception('Lỗi lấy danh sách movie: ' . $e->getMessage());
        }
    
    }

    public function movieDetail($id) {
        try {
            $relationship = ['classify', 'language', 'format', 'category', 'director', 'performers'];
            return $this->movieRepository->findById($id, $relationship);
        } catch (Exception $e) {
            throw new Exception('Lỗi lấy chi tiết Movie: '. $e->getMessage());
        }
    }

   

}