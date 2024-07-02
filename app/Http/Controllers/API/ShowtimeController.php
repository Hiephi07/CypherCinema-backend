<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowtimeController extends Controller
{
    public function showtimes(Request $req) {
    try {
        $dateString = $req->d;
        $date = Carbon::createFromFormat('Y-m-d', Carbon::parse($dateString)->format('Y-m-d'));

        $nowDate = Carbon::now()->toDateString();
        $nowTime = Carbon::now()->toTimeString();

        $movie = Movie::findOrFail($req->id);

        $showtimes = $movie->showtimes()
            ->with(['room.theater'])
            ->where(function ($query) use ($date, $nowDate, $nowTime) {
                if ($date->isSameDay($nowDate)) {
                    $query->where('time_start', '>', $nowTime);
                }
                $query->whereDate('date', $date);
            })
            ->orderBy('time_start')->get();

        $result = $showtimes->groupBy(function ($item) {
            return $item->room->theater->id;
        })
        ->map(function ($sessions, $cinemaID) use ($movie) {
            $theater = $sessions->first()->room->theater;
            return [
                'title' => $theater->name,
                'address' => $theater->address,
                'cinemaID' => $cinemaID,
                'sessions' => $sessions->map(function ($showtime) use ($movie) {
                    return [
                        'showtimeID' => $showtime->id,
                        'time' => $showtime->time_start,
                        'date' => $showtime->date,
                        'language' => $movie->language->name,
                        'format' => $movie->format->name
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
        ], 500);
    }
}
}
