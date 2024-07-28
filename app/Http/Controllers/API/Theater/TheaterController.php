<?php

namespace App\Http\Controllers\API\Theater;

use App\Http\Controllers\Controller;
use App\Http\Requests\Theater\TheaterRequest;
use App\Http\Requests\Theater\TheaterUpdateRequest;
use App\Http\Resources\Theater\TheaterResource;
use App\Services\Theater\TheaterService;
use Exception;

class TheaterController extends Controller
{
    protected $theaterService;

    public function __construct(TheaterService $theaterService)
    {
        $this->theaterService = $theaterService;
    }

    public function listTheater()
    {
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

    public function theaterDetail($id)
    {
        try {
            $theater = $this->theaterService->theaterDetail($id);
            
            return (new TheaterResource($theater))->additional([
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

    public function createTheater(TheaterRequest $req)
    {
        try {
            $data = $req->except('image');
            $data['image'] = $req->file('image');

            $theater = $this->theaterService->createTheater($data);

            return (new TheaterResource($theater))->additional([
                'status' => true,
                'msg' => 'Tạo mới theater thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function updateTheater(TheaterUpdateRequest $req, $id)
    {
        try {
            $data = $req->all();
            if ($req->hasFile('image')) {
                $data['image'] = $req->file('image');
            }

            $theater = $this->theaterService->updateTheater($data, $id);

            return (new TheaterResource($theater))->additional([
                'status' => true,
                'msg' => 'Cập nhật theater thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function deleteTheater($id)
    {
        try {
            $this->theaterService->deleteTheater($id);

            return response()->json([
                'status' => true,
                'data' => null,
                'msg' => 'Theater đã được xóa thành công'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
