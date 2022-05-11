<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $start = Carbon::create($request->startDate, $request->startTime);
        $end = Carbon::create($request->endDate, $request->endTime);

        return Event::create([
            'start' => $start,
            'end' => $end,
            'title' => $request->title,
        ]);
    }
}
