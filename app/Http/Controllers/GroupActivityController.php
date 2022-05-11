<?php

namespace App\Http\Controllers;

use App\Client;
use App\Event;
use App\GroupActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupActivityController extends Controller
{
    public function index()
    {
        $groupActivities = GroupActivity::with('events')->get();

        return $groupActivities;
    }

    public function store(Request $request)
    {
        // return $request;
        $validation = $request->validate(
            [
                'staff_id' => 'required',
                'programName' => 'required',
                'type' => 'required',
                'description' => 'required',
                'location' => 'required',
                'funder' => 'required',
                'event.title' => 'required',
                'event.startDate' => 'required|date',
                'event.startTime' => 'required|before:event.endTime',
                'event.endTime' => 'required|after:event.startTime',
                'event.serviceDelivery' => 'required|string',
                'event.capacity' => 'required|string',
            ],
            [
                'staff_id.required' => 'Please select a facilitator',
                'programName.required' => 'Program name is required',
                'type.required' => 'Group activity type is required',
                'description.required' => 'Group activity description is required',
                'location.required' => 'Group activity location is required',
                'funder.required' => 'Funder is required',
                'event.title.required' => 'Title is required',
                'event.startDate.required' => 'Date is required',
                'event.startDate.date' => 'Date should be a valid date',
                'event.startTime.required' => 'Start time is required',
                'event.startTime.before' => 'Start time has to be earlier than End time',
                'event.endTime.required' => 'End time is required',
                'event.endTime.after' => 'End time has to be later than Start time',
                'event.capacity.required' => 'Seating Capacity is required',
                'event.serviceDelivery.required' => 'Service Delivery Method is required',
            ]
        );
        $event = $request->event;

        $newStartDate = new Carbon($event['startDate']);
        $newStartDate = $newStartDate->toDateString();

        $start = (new \DateTime($newStartDate . 'T' . $event['startTime']))->format('Y-m-d H:i:s');
        $end = (new \DateTime($newStartDate . 'T' . $event['endTime']))->format('Y-m-d H:i:s');


        $groupActivity = GroupActivity::create([
            'staff_id' => $request->staff_id,
            'programName' => $request->programName,
            'type' => $request->type,
            'description' => $request->description,
            'location' => $request->location,
            'funder' => $request->funder,
        ]);

        return $groupActivity->events()->create([
            'start' => $start,
            'end' => $end,
            'title' => $event['title'],
            'type' => $event['type'],
            'backgroundColor' => $event['backgroundColor'],
            'borderColor' => $event['borderColor'],
            'textColor' => $event['textColor'],
            'meetingLink' => $event['meetingLink'],
            'capacity' => intval($event['capacity']),
            'serviceDelivery' => $event['serviceDelivery'],
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate(
            [
                'staff_id' => 'required',
                'programName' => 'required',
                'type' => 'required',
                'description' => 'required',
                'location' => 'required',
                'funder' => 'required',
                'event.title' => 'required',
                'event.startDate' => 'required|date',
                'event.startTime' => 'required|before:event.endTime',
                'event.endTime' => 'required|after:event.startTime',
            ],
            [
                'staff_id.required' => 'Please select a facilitator',
                'programName.required' => 'Program name is required',
                'type.required' => 'Group activity type is required',
                'description.required' => 'Group activity description is required',
                'location.required' => 'Group activity location is required',
                'funder.required' => 'Funder is required',
                'event.title.required' => 'Title is required',
                'event.startDate.required' => 'Date is required',
                'event.startDate.date' => 'Date should be a valid date',
                'event.startTime.required' => 'Start time is required',
                'event.startTime.before' => 'Start time has to be earlier than End time',
                'event.endTime.required' => 'End time is required',
                'event.endTime.after' => 'End time has to be later than Start time',
            ]
        );

        $requestEvent = $request->event;

        $newStartDate = new Carbon($requestEvent['startDate']);
        $newStartDate = $newStartDate->toDateString();

        $start = (new \DateTime($newStartDate . 'T' . $requestEvent['startTime']))->format('Y-m-d H:i:s');
        $end = (new \DateTime($newStartDate . 'T' . $requestEvent['endTime']))->format('Y-m-d H:i:s');

        $event = Event::find($id);

        $event->update([
            'start' => $start,
            'end' => $end,
            'title' => $requestEvent['title'],
            'type' => $requestEvent['type'],
            'backgroundColor' => $requestEvent['backgroundColor'],
            'borderColor' => $requestEvent['borderColor'],
            'textColor' => $requestEvent['textColor'],
        ]);

        $groupActivity = $event->groupActivity()->update([
            'staff_id' => $request->staff_id,
            'programName' => $request->programName,
            'type' => $request->type,
            'description' => $request->description,
            'location' => $request->location,
            'funder' => $request->funder,
        ]);

        return $event;

    }

    public function registerClient(Request $request)
    {
        $groupActivity = GroupActivity::find($request->groupActivity_id);

        $groupActivity->clients()->attach($request->client_id);

        return 204;
    }

    public function unregisterClient(Request $request)
    {
        $groupActivity = GroupActivity::find($request->groupActivity_id);

        $event = $groupActivity->events()->first();

        $groupActivity->clients()->detach($request->client_id);
        $event->attendances()->detach($request->client_id);

        return 204;
    }

    public function registrations($id)
    {
        $groupActivity = GroupActivity::find($id);

        return $registrations = $groupActivity->clients()->with('user')->get();
    }
}
