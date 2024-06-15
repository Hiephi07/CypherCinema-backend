<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function listEvent() {
        try {
            $data = Event::get();
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
