<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function listEvent(Request $req) {
        $limit = $req->limit ?: '';
        try {
            $data = Event::limit($limit)->get();
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
}
