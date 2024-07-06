<?php

namespace App\Http\Controllers\API\Showtime;

use App\Http\Controllers\Controller;
use App\Services\Showtime\ShowtimeService;
use Exception;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    protected $showtimeService;

    public function __construct(ShowtimeService $showtimeService)
    {
        $this->showtimeService = $showtimeService;
    }

    public function getShowtimes(Request $req)
    {
        try {
            $data = $this->showtimeService->getMovieShowtimes($req->id, $req->d);

            return response()->json([
                'status' => true,
                'data' => $data,
                'msg' => 'Thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);    
        }

    }

}
