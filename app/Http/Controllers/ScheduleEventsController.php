<?php

namespace App\Http\Controllers;

use App\Event;
use App\GroupActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleEventsController extends Controller
{
    public function index()
    {
        return Event::with('groupActivity')->get();
    }

    public function show($id)
    {
        $event = Event::find($id);

        $eventType = $event->type;

        switch ($eventType) {
            case "groupActivity":
                $groupActivity = $event->groupActivity()->get();
                $event->groupActivity = $groupActivity[0];
                break;
        }

        return $event;
    }

    public function getAttendances($id)
    {
        $event = Event::find($id);

        return $event->attendances()->with('user')->get();
    }

    public function attend(Request $request)
    {
        $event = Event::find($request->event_id);

        $event->attendances()->toggle([$request->client_id]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $schedule = $event->groupActivity()->first();
        $event->attendances()->detach();
        $schedule->clients()->detach();

        $schedule->delete();
        $event->delete();

        return 204;
    }
}
