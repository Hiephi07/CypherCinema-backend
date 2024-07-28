<?php 

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\Event\EventRepositoryInterface;
use Exception;

class EventRepository implements EventRepositoryInterface {
    protected $event;

    public function __construct(Event $event)
    {   
        $this->event = $event;
    }
    
    public function getAll($limit) {
        try {
            return $this->event->limit($limit)->get();
        } catch (Exception $e) {
            throw new Exception('Lỗi tìm nạp tất cả event: ' . $e->getMessage());
        }
    }

    public function getEventById($id)
    {
        try {
            return $this->event->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy event theo id: ' . $e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return $this->event->create($data);
        } catch (Exception $e) {
            throw new Exception('Không thể thêm mới event: ' . $e->getMessage());
        }
    }

    public function update($data, $id)
    {
        try {
            $event = $this->getEventById($id);
            return $event->update($data);
        } catch (Exception $e) {
            throw new Exception('Không thể cập nhật event: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $event = $this->event->findOrFail($id);
            return $event->delete();
        } catch (Exception $e) {
            throw new Exception('Không tìm thấy event: ' . $e->getMessage());
        }
    }
}