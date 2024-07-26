<?php 

namespace App\Services\Theater;

use App\Helpers\ImageHelper;
use App\Repositories\Theater\TheaterRepositoryInterface;
use Exception;

class TheaterService {
    protected $theaterRepository;

    public function __construct(TheaterRepositoryInterface $theaterRepository)
    {
        $this->theaterRepository = $theaterRepository;
    }

    public function listTheater() {
        try {
            return $this->theaterRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách rạp: ' . $e->getMessage());
        }
    }

    public function theaterDetail($id) {
        try {
            return $this->theaterRepository->findById($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách rạp: ' . $e->getMessage());
        }
    }

    public function createTheater($data) {
        try {
            $file = $data['image'];
            $fileName = ImageHelper::generateName($file);
            $data['image'] = $fileName;

            $theater = $this->theaterRepository->create($data);

            if($theater) {
                ImageHelper::uploadImage($file, $fileName, 'theaters');
            }
            return $theater;
        } catch(Exception $e) {
            throw new Exception('Lỗi khi thêm mới theater: ' . $e->getMessage());
        }
    }

    public function updateTheater($id, $data) {
        try {
            $theater = $this->theaterRepository->findById($id);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                // Xóa ảnh cũ khỏi storage
                $oldImagePath = 'public/theaters/' . $theater->image;
                // if (Storage::exists($oldImagePath)) {
                //     Storage::delete($oldImagePath);
                // }

                // Xử lý và lưu ảnh mới
                $file = $data['image'];
                $fileName = ImageHelper::generateName($file);
                $data['image'] = $fileName;
                ImageHelper::uploadImage($file, $fileName, 'theaters');
            } else {
                // Nếu không có ảnh mới, giữ lại ảnh cũ
                unset($data['image']);
            }

            // Cập nhật dữ liệu theater
            $theater = $this->theaterRepository->update($id, $data);

            return $theater;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật theater: ' . $e->getMessage());
        }
    }

    public function deleteTheater($id) {
        try {
            $theater = $this->theaterRepository->findById($id);

            $success = $this->theaterRepository->delete($id);

            if ($success) {
                ImageHelper::removeImage($theater->image, 'theaters');
            }
            return $success;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi xóa theater theo id: ' . $e->getMessage());
        }
    }
}