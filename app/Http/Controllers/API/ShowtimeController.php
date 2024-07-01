<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    public function showtimes(Request $req)
{
    try {
        $nowDate = Carbon::now()->toDateString();
        $nowTime = Carbon::now()->toTimeString();

        $movie = Movie::findOrFail($req->id);

        $showtimes = $movie->showtimes()
            ->with(['room.theater'])
            ->where(function ($query) use ($nowDate, $nowTime) {
                $query->where('date', '>', $nowDate)
                      ->orWhere(function ($query) use ($nowDate, $nowTime) {
                          $query->where('date', '=', $nowDate)
                                ->where('time_start', '>', $nowTime);
                      });
            })
            ->get();

        $result = $showtimes->groupBy(function ($item) {
            return $item->room->theater->id;
        })
        ->map(function ($sessions, $cinemaID) {
            $theater = $sessions->first()->room->theater;
            preg_match('/Địa điểm: (.*?)(?:\r\n|$)/s', $theater->content, $matches);
            $address = isset($matches[1]) ? trim($matches[1]) : null;
            return [
                'title' => $theater->name,
                'address' => $address,
                'cinemaID' => $cinemaID,
                'sessions' => $sessions->map(function ($showtime) {
                    return [
                        'showtimeID' => $showtime->id,
                        'time' => $showtime->time_start,
                        'date' => $showtime->date,
                    ];
                }),
            ];
        })->values();

        return response()->json([
            'status' => true,
            'data' => $result,
            'msg' => 'Lấy thông tin suất chiếu phim thành công',
        ]);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'errors' => [
                'msg' => 'Lấy thông tin suất chiếu phim thất bại'
            ]
        ]);
    }
}
}
