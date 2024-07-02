<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use Exception;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function seats(Request $req) {
        try {
            $movie = Movie::findOrFail($req->movieID);
            $showtime = Showtime::with('room.theater', 'room.seats')->findOrFail($req->showtimeID);

            $seatsByRows = $showtime->room->seats->groupBy('row')
            ->map(function ($seats, $rowName) {
                return [
                    'name' => $rowName,
                    'cols' => $seats->map(function ($seat) {
                        return [
                            'seatID' => $seat->id,
                            'col' => $seat->col,
                            'price' => $seat->price,
                            'type' => $seat->seat_type_id,
                            'status' => $seat->status,
                        ];
                    })
                ];
            })->values();

            return response()->json([
                'status' => true,
                'data' => [
                    'cinema' => [
                        'name' => $showtime->room->theater->name
                    ],
                    'room' => [
                        'id' => $showtime->room->id,
                        'name' => $showtime->room->name,
                        'totalSeats' => $showtime->room->seats->count()
                    ],
                    'seats' => [
                        'row' => $seatsByRows
                    ],
                    'movie' => [
                        'name' => $movie->name,
                        'classify' => $movie->classify->name,
                        'language' => $movie->language->name,
                        'format' => $movie->format->name,
                    ],
                    'showtimes' => [
                        'day' => $showtime->date,
                        'time' => $showtime->time_start
                    ]
                ],
                'msg' => 'Lấy danh sách ghế thành công'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'msg' => 'Lấy danh sách ghế không thành công'
                ]
            ], 500);
        }
    }
}
