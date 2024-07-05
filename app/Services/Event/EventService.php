<?php 

namespace App\Services\Event;

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
}