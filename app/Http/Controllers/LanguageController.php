<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::orderBy('language', 'asc')->get();

        return $languages;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'language' => 'required|unique:languages,language'
            ],

            [
                'language.unique' => 'This language already exists.'
            ]
        );

        $language = Language::create($request->all());

        return response($language, 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate(
            [
                'language' => 'required|unique:languages,language'
            ],

            [
                'language.unique' => 'This language already exists.'
            ]
        );

        $language = Language::find($id)->update([
            'language' => $request->language
        ]);

        return response('',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $language = Language::find($id)->delete();

        return response('', 204);
    }
}
