<?php 

namespace App\Services\Banner;

use App\Repositories\Banner\BannerRepository;
use Exception;

class BannerService {

    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function listBanner() {
        try {
            return $this->bannerRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách banner: ' . $e->getMessage());
        }
    }

    public function getBanner($type) {
        try {
            return $this->bannerRepository->getByType($type);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy banner theo type: ' . $e->getMessage());
        }
    }
}