<?php 

namespace App\Repositories\Banner;

use App\Models\Banner;
use Exception;

class BannerRepository implements BannerRepositoryInterface {
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    public function getAll() {
        try {
            return Banner::where('status', 1)->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả banner: ' . $e->getMessage());
        }
    } 

    public function getByType($type)
    {
        try {
            if($type == 'main') 
                return Banner::where([['status', 1], ['type', 'main']])->get();
            else if($type == 'sub') 
                return Banner::where([['status', 1], ['type', 'sub']])->get();
            else 
                throw new Exception();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy banner theo type: ' . $e->getMessage());
        }
    }
}