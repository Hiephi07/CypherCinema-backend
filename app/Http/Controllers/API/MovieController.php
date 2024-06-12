<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function listMovie() {
        try {
            $data = Movie::with('classify', 'language', 'format', 'category')->get();
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
                'msg' => 'Thất bại'
            ]);
        }
    }
    
}
