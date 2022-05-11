<?php

namespace App\Http\Controllers;

use App\Outcome;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
   public function store(Request $request){
    $validation = $request->validate(
        [
            'category_id' => 'required',
            'outcome' => 'required',
            'status' => 'required',
        ],

        [
            'category_id.required' => 'Category is Requird.',
            'outcome.required' => 'Outcome is Requird',
            'status.required' => 'Status is Requird',

        ]
    );

    $outcome = Outcome::create($request->all());

    return response($outcome, 200);
   }
}
