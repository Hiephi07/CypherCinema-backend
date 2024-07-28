<?php 

namespace App\Services\Banner;

use App\Helpers\ImageHelper;
use App\Repositories\Banner\BannerRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

class BannerService {

    protected $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
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

    public function createBanner($data) {
        try {
            $file = $data['image'];
            $fileName = ImageHelper::generateName($file);
            $data['image'] = $fileName;

            $banner = $this->bannerRepository->create($data);

            if($banner) {
                ImageHelper::uploadImage($file, $fileName, 'banners');
            }

            return $banner;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi tạo mới banner: ' . $e->getMessage());
        }
    }

    public function updateBanner($data, $id) {
        try {
            $banner = $this->bannerRepository->getBannerById($id);
    
            if (isset($data['image'])) {
                $file = $data['image'];
                $fileName = ImageHelper::generateName($file);
                $data['image'] = $fileName;
            } else {
                $data['image'] = $banner->image;
            }
            $update = $this->bannerRepository->update($data, $id);

            if ($update && isset($file)) {
                ImageHelper::uploadImage($file, $fileName, 'banners');
                ImageHelper::removeImage($banner->image, 'banners');
            }

            $updatedBanner = $this->bannerRepository->getBannerById($id);
            return $updatedBanner;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật banner: ' . $e->getMessage());
        }
    }

    public function getBanner($type) {
        try {
            return $this->bannerRepository->getByType($type);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy banner theo type: ' . $e->getMessage());
        }
    }

    public function detailBanner($id) {
        try {
            return $this->bannerRepository->getBannerById($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy banner theo id: ' . $e->getMessage());
        }
    }

    public function deleteBanner($id) {
        try {
            $banner = $this->bannerRepository->getBannerById($id);

            $success = $this->bannerRepository->delete($id);

            if ($success) {
                ImageHelper::removeImage($banner->image, 'banners');
            }
            return $success;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi xóa banner theo id: ' . $e->getMessage());
        }
    }
}