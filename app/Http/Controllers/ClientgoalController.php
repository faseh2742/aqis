<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientgoal;

class ClientgoalController extends Controller
{

    public function index()
    {
      $clientgoals = Clientgoal::all();
      // $clientgoal = client::where('visible', '!=', 0)->latest()->get();

      return $clientgoals;
    }

    public function store(Request $request)
    {

      $clientgoal = Clientgoal::create($request->all());

      return $clientgoal;
    }

    public function show($id)
    {
        $clientgoal = Clientgoal::findorFail($id);

        return $clientgoal;
    }

    public function update(Request $request, $id)
    {
        $clientgoal = Clientgoal::findorFail($id);
        $clientgoals->update($request->all());

        return $clientgoal;

    }

    public function destroy($id)
    {
      $clientgoal = Clientgoal::findorFail($id);
      $clientgoal->delete();

      return 204;
    }
}