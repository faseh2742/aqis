<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\ClientDocs;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ClientDocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCilentDocs(Request $request,$id)
    {
     $docs = DB::table('clientdocuments')->where('client_id', $id)->orderBy('created_at','desc')->get();
     return $docs;
    }
    public function index(Request $request)
    {

       // return $request->id;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_name' => 'required',
            'doc_file' => 'required|max:50024',
        ]);

          $user=User::where('id','=',$request->client_id)->first();
          $fileName = $request->doc_file;
          $filename = time().$fileName->getClientOriginalName();
          $fileNameNew = time() . '.' . $request->doc_file->getClientOriginalExtension();
          $request->doc_file->move(public_path('uploads'), $filename);
          $cilent_id = (int)$request->client_id;
          $user_id =(int)$user->id;
            $client = DB::table('clientdocuments')->insert([
                 'user_id' => $user_id ,
                 'client_id' => $cilent_id,
                 'doc_name' => $request->doc_name,
                 'doc_file' =>  $filename,
           ]);
           return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientDocs  $clientDocs
     * @return \Illuminate\Http\Response
     */
    public function show(ClientDocs $clientDocs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientDocs  $clientDocs
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientDocs $clientDocs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientDocs  $clientDocs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientDocs $clientDocs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientDocs  $clientDocs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientDocs $clientDocs)
    {
        //
    }
}
