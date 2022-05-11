<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Aptemplate;
use App\Client;

class SearchController extends Controller
{

    public function searchClient (Request $request) 
    {
        $keyword = $request->input('keyword');
        $resultClients = Client::search($keyword);

        return $resultClients;

    }
}
