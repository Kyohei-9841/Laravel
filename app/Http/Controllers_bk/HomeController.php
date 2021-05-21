<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;
use App\User;

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
        $fishing_results = $this->get_result_all();
        return view('home')->with(compact('fishing_results'));    
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
        $fr_sub_sub = \DB::table('fishing_results as fr_sub_sub')
                ->select(\DB::raw('DISTINCT fr_sub_sub.size as size'));

        $fr_sub = \DB::table($fr_sub_sub, 'fr_sub')
                ->select(\DB::raw('COUNT(*) + 1'))
                ->whereColumn('fr_sub.size', '>', 'fishing_results.size')
                ;

        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->selectSub($fr_sub, 'rank')
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 1)
                ->orderBy('fishing_results.size', 'desc')
                ->get();

                \Log::debug(print_r($query_result, true));

        return $query_result;
    }
}
