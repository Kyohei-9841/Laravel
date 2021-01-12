<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fishing_results_data = new FishingResults();
        $fishing_results = $fishing_results_data->where('user_id', \Auth::user()->id)->get();
        return view('home')->with(compact('fishing_results'));
    }
}