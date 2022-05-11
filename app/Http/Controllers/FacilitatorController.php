<?php

namespace App\Http\Controllers;

use App\Clientmeeting;
use App\Facilitator;
use App\User;
use Illuminate\Http\Request;

class FacilitatorController extends Controller
{
   
    public function index()
    {
      $facilitators = Facilitator::with(['user'])->where('active', '1')
          ->orderBy('id', 'DESC')->paginate(10);
      return $facilitators;
    }

    public function all()
    {
        $facilitators = Facilitator::with(['user'])->get();
        foreach ($facilitators as $key => $facilitator) {
            $facilitator->name = $facilitator->firstName 
            . " " . $facilitator->lastName;
        }
        return $facilitators;
    }


    public function show($id)
    {
        $facilitator = Facilitator::with('user')->findorFail($id);

        return $facilitator;
    }

    public function update(Request $request, $id)
    {
        $facilitator = Facilitator::findorFail($id);
        $facilitator->firstName = $request->firstName;
        $facilitator->lastName =$request->lastName;
        $facilitator->phonePrimary =$request->phonePrimary;
        $facilitator->gender =$request->gender;
        $facilitator->address =$request->address;

        $facilitator->save();

        return $facilitator;

    }

    public function destroy($id)
    {
      $facilitator = Facilitator::findorFail($id);
      $facilitator->delete();

      return 204;
    }

    public function search(Request $request) 
    {
        $keyword =$request->input('string');
        $resultFacilitators = Facilitator::with('user')->search($keyword)->take(10)->get();

        return $resultFacilitators;

    }

    
    public function FacilMeet(Request $request){
      
      $all = Facilitator::all();
      $tmp = [];
      $labels = [];
      foreach ($all as $f) {
        $tmp[] = Clientmeeting::where('facilitator',$f->email)->whereBetween('created_at', [$request->startDate, $request->endDate])->count();
        $labels[] = $f->id;
      }
      
      $series[0] = $tmp;
      
      $response= array('Chart' => "FacilMeet" ,'labels'=> $labels, 'series' => $series);
      return $response;
    }
}
