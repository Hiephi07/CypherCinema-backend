<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityResource;
use App\Services\City\CityService;
use Exception;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function listCity() {
        try {
            $cities = $this->cityService->listCity();

            return CityResource::collection($cities)->additional([
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
