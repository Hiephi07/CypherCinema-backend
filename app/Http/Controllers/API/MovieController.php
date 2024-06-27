<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function listMovie(Request $req) {
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

            if(!empty($req->state)) {
                $data = ($req->state == 'showing') 
                ? Movie::with(['classify', 'language', 'format', 'category', 'showtimes' => $filterShowtime])
                ->whereHas('showtimes', $filterShowtime)

                : Movie::with('classify', 'language', 'format', 'category', 'showtimes')
                ->where('premiere', '>', Carbon::now()->toDateTimeString())
                ->whereDoesntHave('showtimes');
                
            } else {
                $data = Movie::with('classify', 'language', 'format', 'category', 'showtimes');
            }
            $data = $data->orderBy('premiere')->get();
            $data->transform(function ($movie) {
                return [
                    'id' => $movie->id,
                    'name' => $movie->name,
                    'image' => $movie->image,
                    'classify' => $movie->classify ? $movie->classify->name : null,
                    'language' => $movie->language ? $movie->language->name : null,
                    'format' => $movie->format ? $movie->format->name : null,
                    'category' => $movie->category ? $movie->category->name : null,
                ];
            });
            return response()->json([
                'status' => true,
                'data' => $data,
                'msg' => 'Thành công'
            ]);
        } catch (QueryException $exception) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thất bại'
            ]);
        }
    }

    public function detailMovie(Request $req) {
        try {
            $movie = Movie::with('classify', 'language', 'format', 'category', 'director', 'performers')->findOrFail($req->id);
            
            $data = [
                'id' => $movie->id,
                'name' => $movie->name,
                'image' => $movie->image,
                'content' => $movie->content,
                'trailer' => $movie->trailer,
                'premiere' => $movie->premiere,
                'time' => $movie->time,
                'classify' => $movie->classify ? ['name' => $movie->classify->name, 'desc' => $movie->classify->desc] : null,
                'language' => $movie->language ? $movie->language->name : null,
                'format' => $movie->format ? $movie->format->name : null,
                'category' => $movie->category ? $movie->category->name : null,
                'director' => $movie->director ? $movie->director->name : null,
                'performers' => $movie->performers->pluck('name')
            ];
    
            return response()->json([
                'status' => true,
                'data' => $data,
                'msg' => 'Thành công'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thất bại'
            ]);
        }
    }
    
}
