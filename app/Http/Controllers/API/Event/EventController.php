<?php

namespace App\Http\Controllers\API\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventRequest;
use App\Http\Requests\Event\EventUpdateRequest;
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
        try {
            $limit = $req->input('limit', '');
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

    public function detailEvent($id) {
        try {
            $event = $this->eventService->detailEvent($id);
            return (new EventResource($event))->additional([
                'status' => true,
                'msg' => 'Lấy chi tiết event thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function createEvent(EventRequest $req) {
        try {
            $data = $req->all();
            if($req->hasFile('image')) {
                $data['image'] = $req->file('image');
            }

            $event = $this->eventService->createEvent($data);
            return (new EventResource($event))->additional([
                'status' => true,
                'msg' => 'Tạo mới event thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function updateEvent(EventUpdateRequest $req, $id) {
        try {
            $data = $req->all();
            if ($req->hasFile('image')) {
                $data['image'] = $req->file('image');
            }
            $event = $this->eventService->updateEvent($data, $id);

            return (new EventResource($event))->additional([
                'status' => true,
                'msg' => 'Cập nhật event thành công'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteEvent($id)
    {
        try {
            $this->eventService->deleteEvent($id);
            
            return response()->json([
                'status' => true,
                'data' => null,
                'msg' => 'Event đã được xóa thành công'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'data' => null,
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
