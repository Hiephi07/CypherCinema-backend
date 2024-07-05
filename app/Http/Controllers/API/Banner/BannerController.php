<?php

namespace App\Http\Controllers\API\Banner;

use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerResource;
use App\Models\Banner;
use App\Services\Banner\BannerService;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function getBanner(Request $req) {
        $type = $req->input('type', null);
        
        try {
            if(!$type) {
                $data = $this->bannerService->listBanner();
            } else {
                $data = $this->bannerService->getBanner($type);
            }
            
            return BannerResource::collection($data)->additional([
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
