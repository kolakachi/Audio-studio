<?php

namespace App\Http\Controllers;

use Log, Exception;
use Illuminate\Http\Request;

class JobFinderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscription');
        $this->middleware('enterprise');
    }

    public function index(){
        
        $data = [
            'page' => 'job-finder',
            'pageClass' => 'job-finder-page'

        ];
        return view('app.job-finder.index', $data);

    }

    public function searchJobs(Request $request)
    {
        try {
            $Token = 'br4J3V1RjVlb4GCsFzFgSJfHVXehns';

            $keyword = $request->keyword;
            $url =
                'https://www.freelancer.com/api/projects/0.1/projects/active/?compact=&query=' .
                $keyword .
                '';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'freelancer-oauth-v1 ' . $Token,
                ],
            ]);
            $contents = $res->getBody()->getContents();
            $response = json_decode($contents);
            $jobs = $response->result->projects;

            return response()->json([
                'status' => 'success',
                'jobs' => $jobs,
            ]);
        } catch (\Exception $error) {
            Log::info('JobFinderController@searchJobs error message: '. $error->getMessage());
            $message = 'Unable to search. Encountered an error.';
            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], 500);
        }
    }
}
