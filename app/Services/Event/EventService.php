<?php 

namespace App\Services\Event;

use App\Helpers\ImageHelper;
use App\Repositories\Event\EventRepositoryInterface;
use Exception;

class EventService {

    protected $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function listEvent($limit) {
        try {
            return $this->eventRepository->getAll($limit);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy danh sách sự kiện: ' . $e->getMessage());
        }
    }

    public function detailEvent($id) {
        try {
            return $this->eventRepository->getEventById($id);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi lấy event theo id: ' . $e->getMessage());
        }
    }

    public function createEvent($data) {
        try {
            $file = $data['image'];
            $fileName = ImageHelper::generateName($file);
            $data['image'] = $fileName;

            $event = $this->eventRepository->create($data);

            if($event) {
                ImageHelper::uploadImage($file, $fileName, 'events');
            }

            return $event;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi thêm mới event: ' . $e->getMessage());
        }
    }

    public function updateEvent($data, $id) {
        try {
            $event = $this->eventRepository->getEventById($id);
    
            if (isset($data['image'])) {
                $file = $data['image'];
                $fileName = ImageHelper::generateName($file);
                $data['image'] = $fileName;
            } else {
                $data['image'] = $event->image;
            }
            $updated = $this->eventRepository->update($data, $id);

            if ($updated && isset($file)) {
                ImageHelper::uploadImage($file, $fileName, 'events');
                ImageHelper::removeImage($event->image, 'events');
            }

            $updatedEvent = $this->eventRepository->getEventById($id);
            return $updatedEvent;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi cập nhật event: ' . $e->getMessage());
        }
    }

    public function deleteEvent($id) {
        try {
            $event = $this->eventRepository->getEventById($id);

            $success = $this->eventRepository->delete($id);

            if ($success) {
                ImageHelper::removeImage($event->image, 'events');
            }
            return $success;
        } catch (Exception $e) {
            throw new Exception('Lỗi khi xóa event theo id: ' . $e->getMessage());
        }
    }
}