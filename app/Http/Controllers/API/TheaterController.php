<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Exception;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function listTheater() {
        try {
            $data = Theater::select('id', 'name', 'image')->get();
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
            ], 500);
        }
    }

    public function theaterDetail(Request $req) {
        try {
            $theater = Theater::findOrFail($req->id);
            return response()->json([
                'status' => true,
                'data' => $theater,
                'msg' => 'Thành công'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => 'Thất bại'
            ], 500);
        }
    }
}
