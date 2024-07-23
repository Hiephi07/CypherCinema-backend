<?php

namespace App\Http\Controllers\API\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Http\Resources\Banner\BannerResource;
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
        $type = $req->query('type', null);
        
        try {
            if(!$type) {
                $data = $this->bannerService->listBanner();
            } else {
                $data = $this->bannerService->getBanner($type);
            }
            
            return BannerResource::collection($data)->additional([
                'status' => true,
                'msg' => 'Lấy danh sách banner thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function createBanner(BannerRequest $req) {
        try {
            $banner = $this->bannerService->createBanner($req->all());
            return (new BannerResource($banner))->additional([
                'status' => true,
                'msg' => 'Thêm mới banner thành công'
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function detailBanner($id) {
        try {
            $banner = $this->bannerService->detailBanner($id);
            return (new BannerResource($banner))->additional([
                'status' => true,
                'msg' => 'Lấy banner thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteBanner($id) {
        try {
            $this->bannerService->deleteBanner($id);
            return response()->json([
                'status' => true,
                'data' => null,
                'msg' => 'Banner đã được xóa thành công'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
