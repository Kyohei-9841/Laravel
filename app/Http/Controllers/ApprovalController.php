<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;
use App\User;

class ApprovalController extends Controller
{
    public function view(Request $request)
    {
        $user_obj = new User();
        $all_user = $user_obj->get();
        \Log::debug(print_r($all_user, true));
        $fishing_results = $this->get_result_all();
        $user_id = 0;
        return view('approval/view')->with(compact('fishing_results', 'all_user', 'user_id'));
    }

    public function search(Request $request)
    {
        $user_obj = new User();
        $all_user = $user_obj->get();
        \Log::debug(print_r($all_user, true));

        $user_id = $request->approvalSelecter;

        if ($user_id == 0) {
            $fishing_results = $this->get_result_all();
        } else {
            $fishing_results = $this->get_result_user($user_id);
        }        
        return view('approval/view')->with(compact('fishing_results', 'all_user', 'user_id'));
    }

    public function update(Request $request)
    {
        $user_obj = new User();
        $all_user = $user_obj->get();
        \Log::debug(print_r($all_user, true));
        $fishing_results = $this->get_result_all();
        $user_id = 0;
        return view('approval/view')->with(compact('fishing_results', 'all_user', 'user_id'));
    }

    /**
     * 未承認の画像データを取得する
     */
    public function get_result_all()
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 0)
                ->get();

        return $query_result;
    }

    /**
     * 指定したユーザーの未承認の画像データを取得する
     */
    public function get_result_user(int $user_id)
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 0)
                ->where('users.id', '=', $user_id)
                ->get();

        return $query_result;
    }

}
