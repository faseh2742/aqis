<?php

namespace App\Http\Controllers;

use App\Clientworkshop;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ClientworkshopController extends Controller
{

    public function index()
    {
        $clientworkshops = Clientworkshop::where('client_id', $id)
            ->orderBy('id', 'DESC')->get();
        return $clientworkshops;
    }

    public function store(Request $request)
    {
      $request->validate([
        'client_id' => 'required|integer',
        'staff_id' => 'required|integer',
        'programName' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'location'=>'required|string|max:255',
        'duration'=> 'nullable|regex:/^([0-9]{1,2}:[0-9]{2})$/'
      ],
      [
        'staff_id' => 'The facilitator field is required.',
        'duration.regex'=>'The duration should be in the format of hh:mm'
      ]);

      $start_date = new Carbon($request->start_date);
      $end_date = new Carbon($request->end_date);
      
      $duration = strlen($request->duration) == 4 ? 0 . $request->duration : $request->duration;

      $clientworkshop = Clientworkshop::create([
          'client_id' => $request->client_id,
          'programName' => $request->programName,
          'type' => $request->type,
          'description' => $request->description,
          'start_date' => $start_date,
          'end_date' => $end_date,
          'location' => $request->location,
          'funder' => $request->funder,
          'staff_id' => $request->staff_id,
          'notes' => $request->notes,
          'duration'=> $duration,
        ]);

        return $clientworkshop;
    }

    public function show($id)
    {
        $clientworkshop = Clientworkshop::with('staff.user')->where('client_id', $id)->get();

        return $clientworkshop;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
          'client_id' => 'required|integer',
          'staff_id' => 'required|integer',
          'programName' => 'required|string|max:255',
          'start_date' => 'required|date',
          'end_date' => 'required|date',
          'location'=>'required|string|max:255',
          'duration'=> 'nullable|regex:/^([0-9]{1,2}:[0-9]{2})$/'
        ],
        [
          'staff_id' => 'The facilitator field is required.',
          'duration.regex'=>'The duration should be in the format of hh:mm'
        ]);
        
        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);

        $clientworkshop = Clientworkshop::findorFail($id);

        $duration = strlen($request->duration) == 4 ? 0 . $request->duration : $request->duration;

        $clientworkshop->update([
            'client_id' => $request->client_id,
            'programName' => $request->programName,
            'type' => $request->type,
            'description' => $request->description,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'location' => $request->location,
            'funder' => $request->funder,
            'staff_id' => $request->staff_id,
            'notes' => $request->notes,
            'duration'=> $duration,
          ]);

        return $clientworkshop;
    }

    public function destroy($id)
    {
        $clientworkshop = Clientworkshop::findorFail($id);
        $clientworkshop->delete();

        return 204;
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'year' => 'required|digits:4|integer|min:1990|max:' . (date('Y') + 1),
        ]);

        $yearStart = $request->year . '-04-01';

        //get all locations

        $dropdown_id = \DB::table('dropdowns')->where('name', '=', 'location')->pluck('id');
        $locations = \DB::table('dropdown_items')->where('dropdown_id', '=', $dropdown_id)->orderBy('item', 'DESC')->pluck('item');

        $workshops = [];


        //now for each location get inital and repeat values
        foreach ($locations as $location) {
            $startOfMonth = Carbon::parse($yearStart);
            $endOfMonth = Carbon::parse($yearStart)->endOfMonth();
            $workshops[$location] = [];


            $query =  Clientworkshop::where('location', '=', $location)->get();

            for ($m = 1; $m <= 12; ++$m) {
                $month = Carbon::parse($startOfMonth)->format('M-Y');

                $query =  Clientworkshop::where('location', '=', $location)->where('start_date', '>=', date($startOfMonth))
                    ->where('start_date', '<', date($endOfMonth))->where('type', '=', $request->type)->get();

                $workshops[$location][$month]['Participants'] = $query->count();
                $workshops[$location][$month]['# of Activities'] = $query->groupBy('start_date')->unique(['location', 'staff_id'])->count();

                $startOfMonth = Carbon::parse($startOfMonth)->addMonths(1);
                $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth();
            }
        }

        $response = [
            'data' => $workshops,
            'year' => $request->year,
            'alternates' => ['Participants', '# of Activities'],
            'name' => $request->type,
        ];

        return response($response, 200);
    }
}
