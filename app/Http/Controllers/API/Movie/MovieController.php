<?php

namespace App\Http\Controllers\API\Movie;

use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\MovieDetailResource;
use App\Http\Resources\Movie\MovieResource;
use App\Services\Movie\MovieService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }
    
    public function listMovie(Request $req) {
        $state = $req->input('state', null);
        try {
            $data = $this->movieService->listMovie($state);
            return MovieResource::collection($data)->additional([
                'status' => true,
                'msg' => 'Thành công'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function detailMovie($id) {
        try {
            $movie = $this->movieService->movieDetail($id);
    
            return (new MovieDetailResource($movie))->additional([
                'status' => true,
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
