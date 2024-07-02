<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getBanner(Request $req) {
        try {
            if(empty($req->type)) {
                $data = Banner::where('status', 1)->get();
            } else {
                $data = ($req->type == 'main') 
                ? Banner::where([['status', 1], ['type', 'main']])->get()
                : Banner::where([['status', 1], ['type', 'sub']])->get();
            }
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
