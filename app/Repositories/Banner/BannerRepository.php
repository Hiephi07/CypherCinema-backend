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
            return $this->banner->all();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả banner: ' . $e->getMessage());
        }
    } 

    public function create($data)
    {
        try {
            return $this->banner->create($data);
        } catch (Exception $e) {
            throw new Exception('Tạo mới không thành công: ' . $e->getMessage());
        }
    }

    public function getByType($type)
    {
        try {
            if($type == 'main') 
                return $this->banner->where([['status', 1], ['type', 'main']])->get();
            else if($type == 'sub') 
                return $this->banner->where([['status', 1], ['type', 'sub']])->get();
            else 
                throw new Exception();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy banner theo type: ' . $e->getMessage());
        }
    }

    public function getBannerById($id) {
        try {
            return $this->banner->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy banner: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $banner = $this->banner->findOrFail($id);
            return $banner->delete();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy banner: ' . $e->getMessage());
        }
    }
}