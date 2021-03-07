<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;
use App\User;

class RankingController extends Controller
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
        $fishing_results = $this->get_result_all();
        return view('admin/ranking')->with(compact('fishing_results'));    
    }

    /**
     * 全てのユーザーの釣果を取得する
     */
    public function get_result_all()
    {
        // $query_result = FishingResults::select(
        //     \DB::raw('users.name as name'),
        //     \DB::raw('fishing_results.*')
        // )
        // ->join('users', 'fishing_results.user_id', '=', 'users.id')
        // ->where('fishing_results.approval_status', '=', 1)
        // ->orderBy('fishing_results.size', 'desc')
        // ->get();

        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 1)
                ->orderBy('fishing_results.size', 'desc')
                ->get();

        return $query_result;
    }
}
