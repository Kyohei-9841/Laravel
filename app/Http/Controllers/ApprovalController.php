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
        $unapproved_fishing_results = $this->get_unapproved_result_all();
        $approved_fishing_results = $this->get_approved_result_all();
        $user_id = 0;
        return view('approval/view')->with(compact('unapproved_fishing_results', 'approved_fishing_results', 'all_user', 'user_id'));
    }

    public function search(Request $request)
    {
        $user_obj = new User();
        $all_user = $user_obj->get();
        \Log::debug(print_r($all_user, true));

        $user_id = $request->approvalSelecter;

        if ($user_id == 0) {
            $unapproved_fishing_results = $this->get_unapproved_result_all();
            $approved_fishing_results = $this->get_approved_result_all();
        } else {
            $unapproved_fishing_results = $this->get_unapproved_result_user($user_id);
            $approved_fishing_results = $this->get_approved_result_user($user_id);
        }        
        return view('approval/view')->with(compact('unapproved_fishing_results', 'approved_fishing_results', 'all_user', 'user_id'));
    }

    public function update(Request $request)
    {
        \Log::debug(print_r($request->input('id'), true));
        $id = $request->input('id');
        $user_obj = new User();
        $update_results = FishingResults::find($id);
        $update_results->approval_status = 1;
        $update_results->save();
        $all_user = $user_obj->get();
        $unapproved_fishing_results = $this->get_unapproved_result_all();
        $approved_fishing_results = $this->get_approved_result_all();
        $user_id = 0;
        return view('approval/view')->with(compact('unapproved_fishing_results', 'approved_fishing_results', 'all_user', 'user_id'));
    }

    public function delete(Request $request)
    {
        \Log::debug(print_r($request->input('id'), true));
        $id = $request->input('id');
        $user_obj = new User();
        $update_results = FishingResults::find($id);
        $update_results->approval_status = 0;
        $update_results->save();
        $all_user = $user_obj->get();
        $unapproved_fishing_results = $this->get_unapproved_result_all();
        $approved_fishing_results = $this->get_approved_result_all();
        $user_id = 0;
        return view('approval/view')->with(compact('unapproved_fishing_results', 'approved_fishing_results', 'all_user', 'user_id'));
    }

    /**
     * 未承認の画像データを取得する
     */
    public function get_unapproved_result_all()
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
     * 承認の画像データを取得する
     */
    public function get_approved_result_all()
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 1)
                ->get();

        return $query_result;
    }

    /**
     * 指定したユーザーの未承認の画像データを取得する
     */
    public function get_unapproved_result_user(int $user_id)
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

    /**
     * 指定したユーザーの承認の画像データを取得する
     */
    public function get_approved_result_user(int $user_id)
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('users.name as name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.approval_status', '=', 1)
                ->where('users.id', '=', $user_id)
                ->get();

        return $query_result;
    }

}
