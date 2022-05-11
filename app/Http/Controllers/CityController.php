<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('province', 'asc')->orderBy('city', 'asc')->get();

        return $cities;
    }

    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'city' => 'required|unique:cities,city',
                'province' => 'required'
            ],

            [
                'city.unique' => 'This city already exists.'
            ]
        );

        $city = City::create($request->all());

        return response($city, 200);
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate(
            [
                'city' => 'required|unique:cities,city',
                'province' => 'required'
            ],

            [
                'city.unique' => 'This city already exists.'
            ]
        );

        $city = City::find($id)->update($request->all());

        return response('', 200);
    }

    public function destroy($id)
    {
        $city = City::find($id)->delete();

        return response('', 204);
    }
}
