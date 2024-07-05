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
            return ($type == 'main') 
                ? Banner::where([['status', 1], ['type', 'main']])->get()
                : Banner::where([['status', 1], ['type', 'sub']])->get();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy banner theo type: ' . $e->getMessage());
        }
    }
}