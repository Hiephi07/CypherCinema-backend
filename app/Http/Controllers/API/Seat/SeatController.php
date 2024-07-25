<?php

namespace App\Http\Controllers\API\Seat;

use App\Http\Controllers\Controller;
use App\Services\Seat\SeatService;
use Exception;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    protected $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
    }

    public function seats(Request $req)
    {
        try {
            $data = $this->seatService->getSeatsByShowtime($req->showtimeID, $req->movieID);
            return response()->json([
                'status' => true,
                'data' => $data,
                'msg' => 'Lấy danh sách ghế thành công'
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
