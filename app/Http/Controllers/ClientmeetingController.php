<?php

namespace App\Http\Controllers;

use App\Clientworkshop;
use Mail;
use App\Mail\meetingLink;
use App\Clientmeeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientmeetingController extends Controller
{

    public function index()
    {
        $clientmeetings = Clientmeeting::where('client_id', $id)
            ->orderBy('id', 'DESC')->get();
        return $clientmeetings;
    }
    public function updateStatus($id,$status)
    {
        $clientmeeting = Clientmeeting::findorFail($id);
        if ($clientmeeting->status=='Decline'&& $status=='Decline') {
           return "<h1>Meeting Status</h1> <p>You Already Declined this Meeting</p>";
        }
        elseif ($clientmeeting->status=='Accept'&& $status=='Accept') {
            return "<h1>Meeting Status</h1> <p>You Already Accepted this Meeting</p>";
        }
        else{

            $clientmeeting->update([
                'status' => $status,
            ]);
            if ($status=='Decline') {
                return "<h1>Decline</h1> <p>You Declined this Meeting</p>";
            }
            if ($status=='Accept') {
                return "<h1>Decline</h1> <p>You Accepted this Meeting</p>";
            }

        }




    }
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
          'client_id' => 'required|integer',
          'staff_id' => 'required|integer',
          'programName' => 'required|string|max:255',
          'serviceProvided' => 'required|string|max:255',
          'type' => 'required|string|max:255',
          'status' => 'required|string|max:255',
          'serviceDelivery' => 'required|string|max:255',
          'funder' => 'required|string|max:255',
          'date' => 'required|date',
          'location'=>'required|string|max:255',
          'duration'=> 'required|regex:/^([0-9]{1,2}:[0-9]{2})$/'
        ],
        [
          'staff_id.required' => 'The facilitator field is required.',
          'duration.regex'=>'The duration should be in the format of hh:mm'
        ]);

        $date = new Carbon($request->date);
        $duration = strlen($request->duration) == 4 ? 0 . $request->duration : $request->duration;

        $clientmeeting = Clientmeeting::create([
            'client_id' => $request->client_id,
            'programName' => $request->programName,
            'serviceProvided' => $request->serviceProvided,
            'meetingLink' => $request->meetingLink,
            'meetingStatus' => 'pending',
            'type' => $request->type,
            'date' => $date,
            'status' => $request->status,
            'serviceDelivery' => $request->serviceDelivery,
            'location' => $request->location,
            'funder' => $request->funder,
            'staff_id' => $request->staff_id,
            'notes' => $request->notes,
            'duration'=> $duration,
          ]);
          if($request->serviceDelivery=="Video Portal"){
        $user= \App\User::where(['id'=>$request->client_id])->first();
       // $user= \App\User::where(['client_id'=>3432])->first();

           Mail::to($user->email)
                ->queue(new meetingLink($user, $clientmeeting));
          }

        return $clientmeeting;
    }

    public function show($id)
    {
        $clientmeeting = Clientmeeting::with(['staff.user', 'clientaps'])->where('client_id', $id)->get();

        return $clientmeeting;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'programName' => 'required|string|max:255',
            'serviceProvided' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'serviceDelivery' => 'required|string|max:255',
            'funder' => 'required|string|max:255',
            'date' => 'required|date',
            'location'=>'required|string|max:255',
            'duration'=> 'required|regex:/^([0-9]{1,2}:[0-9]{2})$/'
        ],
        [
          'staff_id.required' => 'The facilitator field is required.',
          'duration.regex'=>'The duration should be in the format of hh:mm'
        ]);
        $date = new Carbon($request->date);
        $duration = strlen($request->duration) == 4 ? 0 . $request->duration : $request->duration;


        $clientmeeting = Clientmeeting::findorFail($id);
        $clientmeeting->client_id=$request->client_id;
        $clientmeeting->programName=$request->programName;
        $clientmeeting->serviceProvided= $request->serviceProvided;
        $clientmeeting->meetingLink = $request->meetingLink;
        $clientmeeting->status = 'pending';
        $clientmeeting->type= $request->type;
        $clientmeeting->date= $date;
        $clientmeeting->serviceDelivery = $request->serviceDelivery;
        $clientmeeting->location=$request->location;
        $clientmeeting->funder =$request->funder;
        $clientmeeting->staff_id= $request->staff_id;
        $clientmeeting->notes= $request->notes;
        $clientmeeting->duration= $duration;
        $clientmeeting ->update();


        // $clientmeeting = Clientmeeting::create([
        //     'client_id' => $request->client_id,
        //     'programName' => $request->programName,
        //     'serviceProvided' => $request->serviceProvided,
        //     'meetingLink' => $request->meetingLink,
        //     'meetingStatus' => 'pending',
        //     'type' => $request->type,
        //     'date' => $date,
        //     'status' => $request->status,
        //     'serviceDelivery' => $request->serviceDelivery,
        //     'location' => $request->location,
        //     'funder' => $request->funder,
        //     'staff_id' => $request->staff_id,
        //     'notes' => $request->notes,
        //     'duration'=> $duration,
        //   ]);

          if($request->serviceDelivery=="Video Portal"){
         $user= \App\User::where(['client_id'=>$request->client_id])->first();
       // $user= \App\User::where(['client_id'=>3432])->first();

           Mail::to($user->email)
                ->queue(new meetingLink($user, $clientmeeting));
          }
        return $clientmeeting;
    }

    public function getClientaps($id)
    {
        $meeting = Clientmeeting::find($id);

        $clientAps = $meeting->clientaps()->get();

        foreach ($clientAps as $clientAp) {
            $clientAp->noc = unserialize($clientAp->noc);
        }

        return $clientAps;
    }

    public function destroy($id)
    {
        $clientmeeting = Clientmeeting::findorFail($id);
        $clientmeeting->delete();

        return 204;
    }


    public function ClientMeet(Request $request)
    {

        $date = Carbon::today();
        $date->subMonths(1);
        $series = [];
        $series[0] = [];
        $labels = [];
        $i = 0;
        $tomorrow = Carbon::today();
        $tomorrow->subMonths(1);
        $tomorrow->addDays(1);
        $tmp = [];
        while ($date != Carbon::tomorrow()) {
            $tmp[] = Clientmeeting::whereBetween('created_at', [$date, $tomorrow])->count();
            //$labels[$i] = $date->isoFormat('M-D');
            $labels[] = $date->month . "-" . $date->day;
            $date->addDays(1);
            $tomorrow->addDays(1);
        }
        //$labels = array_reverse($labels);
        //$series[0][0] = array_reverse($tmp);
        $series[0] = $tmp;
        $response = array('Chart' => "ClientMeet", 'labels' => $labels, 'series' => $series);
        return $response;
    }

    public function DeptClientMeet(Request $request)
    {
        $locations = Clientmeeting::select('location')->distinct()->get();

        $series = [];
        $series[0] = [];
        $labels = [];

        $tmp = [];
        foreach ($locations as $location) {
            $tmp[] = Clientmeeting::where('location', $location->location)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();;
            $labels[] = $location->location;
        }

        $series[0] = $tmp;
        $response = array('Chart' => "DeptMeetings", 'labels' => $labels, 'series' => $series);
        return $response;
    }

    public function getMonthly(Request $request)
    {
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->start_date)->addMonths(1);
        $clientMeetQuery = Clientmeeting::where('date', '>=', $start)->where('date', '<', $end)->get();
        $clientGroupQuery = Clientworkshop::where('start_date', '>=', $start) ->where('start_date', '<', $end)->get();

        $initialIrcc = $clientMeetQuery->where('type', '=', 'Initial')->count();
        $repeatIrcc = $clientMeetQuery->where('type', '=', 'Repeat')->unique('client_id')->count('client_id');

        $forums = $clientGroupQuery->where('type', '=', 'Forum')
            ->groupBy('location')->groupBy('start_date')->groupBy('staff_id')->count();
        $forumsPart = $clientGroupQuery->where('type', '=', 'Forum')->count();

        $workshop = $clientGroupQuery->where('type', '=', 'Workshop')
            ->groupBy('location')->groupBy('start_date')->count();
        $workshopPart = $clientGroupQuery->where('type', '=', 'Workshop')->count();

        $response = [
            'month' => $start->format('M-Y'),
            'initialIrcc' => $initialIrcc,
            'repeatIrcc' => $repeatIrcc,
            'forums' => $forums,
            'forumsPart' => $forumsPart,
            'workshop' => $workshop,
            'workshopPart' => $workshopPart

        ];
        return response($response, 200);
    }

    /**Generates the client report for the selected year from April Current Year to March Next Year
     * currently basing everything on the 'type' field as it contains whether the meeting is Initial or Repeat
     *
     * this will need to be replaced in aqis-v2 once the relations have been properly set between the locations, services
     * programs, etc.
     * most of the queries are based on values that have been set in the sandbox and does not support any edits that
     * could be made to the dropdown items for types
     *
     */
    public function getClientsReport(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:1990|max:' . (date('Y') + 1),
        ]);
        $yearStart = $request->year . '-04-01';

        //get all locations

        $dropdown_id = \DB::table('dropdowns')->where('name', '=', 'location')->pluck('id');
        $locations = \DB::table('dropdown_items')->where('dropdown_id', '=', $dropdown_id)->orderBy('item', 'DESC')->pluck('item');

        $meetings = [];


        //now for each location get inital and repeat values
        foreach ($locations as $location) {
            $startOfMonth = Carbon::parse($yearStart);
            $endOfMonth = Carbon::parse($yearStart)->endOfMonth();
            $meetings[$location] = [];


            $query =  Clientmeeting::where('location', '=', $location)->get();

            for ($m = 1; $m <= 12; ++$m) {
                $month = Carbon::parse($startOfMonth)->format('M-Y');

                $query =  Clientmeeting::where('location', '=', $location)->where('date', '>=', date($startOfMonth))
                    ->where('date', '<', date($endOfMonth))->get();

                $meetings[$location][$month]['Initial'] = $query->where('type', '=', 'Initial')->count();
                $meetings[$location][$month]['Repeat'] = $query->where('type', '=', 'Repeat')->count(); //->unique('client_id')->count('client_id');

                $startOfMonth = Carbon::parse($startOfMonth)->addMonths(1);
                $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth();
            }
        }

        $response = [
            'data' => $meetings,
            'year' => $request->year,
            'alternates' => ['Initial', 'Repeat'],
            'name' => 'Clients'
        ];

        return response($response, 200);
    }
}
