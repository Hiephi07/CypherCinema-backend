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
}