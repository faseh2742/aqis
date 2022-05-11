<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clienteducation;
use Carbon\Carbon;

class ClienteducationController extends Controller
{

    public function index($id)
    {
      $clienteducations = Clienteducation::where('client_id', $id)
                ->orderBy('id', 'desc')->get();

      return $clienteducations;
    }

    public function store(Request $request)
    {
//      $request->validate(
//        [
//            'client_id' => 'bail|required|integer',
//            'education_level' => 'required|string|max:255',
//            'major' => 'required|string|max:255|',
//            'graduation_date' => 'nullable|integer|min:1940|max:' . (date('Y') + 10),
//            'education_country' => 'required|string|max:200',
//        ]
//        );

      $clienteducation = Clienteducation::create([
        'client_id' => $request->client_id,
        'education_level' => $request->education_level,
        'major' => $request->major,
        'graduation_date' => $request->graduation_date,
        'education_country' => $request->education_country,
      ]);

      return $clienteducation;
    }

    public function show($id)
    {
        $clienteducation = Clienteducation::where('client_id', $id)->get();

        return $clienteducation;
    }

    public function update(Request $request, $id)
    {
//      $request->validate(
//        [
//            'client_id' => 'bail|required|integer',
//            'education_level' => 'required|string|max:255',
//            'major' => 'required|string|max:255|',
//            'graduation_date' => 'nullable|integer|min:1940|max:' . (date('Y') + 10),
//            'education_country' => 'required|string|max:200',
//        ]
//        );

        $clienteducation = Clienteducation::findorFail($id);
        $clienteducation->update([
          'education_level' => $request->education_level,
          'major' => $request->major,
          'graduation_date' => $request->graduation_date,
          'education_country' => $request->education_country,
        ]);

        return $clienteducation;

    }

    public function destroy($id)
    {
      $clienteducation = Clienteducation::findorFail($id);
      $clienteducation->delete();

      return 204;
    }
}
