<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clienttraining;

class ClienttrainingController extends Controller
{

    public function index($id)
    {
      $clienttrainings = Clienttraining::where('client_id', $id)
                ->orderBy('id', 'desc')->get();

      return $clienttrainings;
    }

    public function store(Request $request)
    {
//      $request->validate([
//        'association' => 'required|string|max:255',
//        'client_id' => 'required|integer|max:255',
//        'country' => 'required|string|max:255',
//        'notes' => 'nullable|string',
//        'subject' => 'required|string',
//        'training_year' => 'nullable|digits:4|integer',
//      ]);

      $clienttraining = Clienttraining::create($request->all());

      return $clienttraining;
    }

    public function show($id)
    {
        $clienttraining = Clienttraining::where('client_id', $id)->get();

        return $clienttraining;
    }

    public function update(Request $request, $id)
    {
        
//      $request->validate([
//        'association' => 'required|string|max:255',
//        'client_id' => 'required|integer|max:255',
//        'country' => 'required|string|max:255',
//        'notes' => 'nullable|string',
//        'subject' => 'required|string',
//        'training_year' => 'nullable|digits:4|integer',
//      ]);


        $clienttraining = Clienttraining::findorFail($id);
        $clienttraining->update($request->all());

        return $clienttraining;

    }

    public function destroy($id)
    {
      $clienttraining = Clienttraining::findorFail($id);
      $clienttraining->delete();

      return 204;
    }
}
