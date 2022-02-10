<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        /**
         * @todo Implement interface so that the search function can be used for other search engines?
         */
        $search_results = (new SpotifyController(new Client()))->search($query);

        return view('search', ['searchTerm' => $query, 'results' => $search_results]);
    }
}
