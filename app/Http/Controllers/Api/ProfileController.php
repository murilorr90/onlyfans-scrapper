<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ScrapeUserJob;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->query('q');

        $results = Profile::search($q)->take(10)->get(['username', 'name', 'bio']);

        return response()->json($results);
    }

    public function scrape(Request $request)
    {
        $username = $request->query('q');

        ScrapeUserJob::dispatch($username);

        return response()->json(['message' => "Scrape job started for {$username}, try again in a few seconds."]);
    }
}
