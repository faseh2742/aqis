<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientemployment;
use function Opis\Closure\unserialize;

class ClientemploymentController extends Controller
{

    public function index($id)
    {
      $clientemployments = Clientemployment::where('client_id', $id)
                ->orderBy('id', 'DESC')->get();

      return $clientemployments;

    }

    public function store(Request $request)
    {
//      $request->validate([
//        'client_id' => 'required|integer',
//        'noc' => 'required',
//        'job_title' => 'required|string|max:255',
//        'experience_years' => 'required|integer',
//        'country' => 'required|string',
//        'notes' => 'nullable|string',
//      ]);

      $clientemployment = Clientemployment::create([
          'client_id' => $request->client_id,
          'noc' => serialize($request->noc),
          'job_title' => $request->job_title,
          // 'field' => $request->field,
          'experience_years' => $request->experience_years,
          'country' => $request->country,
          'notes' => $request->notes,
        ]);

      return $clientemployment;
    }

    public function show($id)
    {
        $clientemployment = Clientemployment::where('client_id', $id)->get();

        foreach ($clientemployment as $employment) {
          $employment->noc = unserialize($employment->noc);
        }

        return $clientemployment;
    }

    public function update(Request $request, $id)
    {
//        $request->validate([
//          'client_id' => 'required|integer',
//          'noc' => 'required',
//          'job_title' => 'required|string|max:255',
//          'experience_years' => 'required|integer',
//          'country' => 'required|string',
//          'notes' => 'nullable|string',
//        ]);

        $clientemployment = Clientemployment::findorFail($id);

        $clientemployment->update([
            'job_title' => $request->job_title,
            'noc' => serialize($request->noc),
            // 'field' => $request->field,
            'experience_years' => $request->experience_years,
            'country' => $request->country,
            'notes' => $request->notes,
          ]);

        return $clientemployment;

    }

    public function destroy($id)
    {
      $clientemployment = Clientemployment::findorFail($id);
      $clientemployment->delete();

      return 204;
    }
}
