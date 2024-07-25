<?php

namespace App\Http\Controllers\API\Theater;

use App\Http\Controllers\Controller;
use App\Http\Resources\Theater\TheaterDetailResource;
use App\Http\Resources\Theater\TheaterResource;
use App\Services\Theater\TheaterService;
use Exception;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    protected $theaterService;

    public function __construct(TheaterService $theaterService)
    {
        $this->theaterService = $theaterService;
    }

    public function listTheater() {
        try {
            $data = $this->theaterService->listTheater();

            return TheaterResource::collection($data)->additional([
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

    public function theaterDetail($id) {
        try {
            $theater = $this->theaterService->theaterDetail($id);
            return (new TheaterDetailResource($theater))->additional([
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
