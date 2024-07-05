<?php

namespace App\Http\Controllers\API\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventResource;
use App\Services\Event\EventService;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function listEvent(Request $req) {
        $limit = $req->input('limit', '');
        try {
            $events = $this->eventService->listEvent($limit);

            return EventResource::collection($events)->additional([
                'status' => true,
                'msg' => 'Thành công'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
