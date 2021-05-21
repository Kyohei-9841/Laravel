<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;

class ApprovalController extends Controller
{
    public function view(Request $request, $id)
    {
        $params = array(
            'entry_user'=> 0,
            'approval'=> 0
        );

        $entry_list = $this->get_entry_data($id);
        $event = $this->get_event($id);
        $fishing_results = $this->search_fishing_results($params, $id);

        foreach($fishing_results as $result) {
            if (!empty($result->image_data)) {
                $result_enc_img = base64_encode($result->image_data);
                $result->enc_img = $result_enc_img;
                $result_imginfo = getimagesize('data:application/octet-stream;base64,' . $result_enc_img);
                $result->imginfo = $result_imginfo['mime'];
            }
        }

        return view('approval.view')->with(compact('fishing_results', 'entry_list', 'params', 'id', 'event'));
    }

    public function search(Request $request, $id)
    {
        $params = array(
            'entry_user'=>$request->input('entry-user'),
            'approval'=>$request->input('approval')
        );

        $entry_list = $this->get_entry_data($id);
        $event = $this->get_event($id);
        $fishing_results = $this->search_fishing_results($params, $id);

        foreach($fishing_results as $result) {
            if (!empty($result->image_data)) {
                $result_enc_img = base64_encode($result->image_data);
                $result->enc_img = $result_enc_img;
                $result_imginfo = getimagesize('data:application/octet-stream;base64,' . $result_enc_img);
                $result->imginfo = $result_imginfo['mime'];
            }
        }

        return view('approval.view')->with(compact('fishing_results', 'entry_list', 'params', 'id', 'event'));
    }

    public function update(Request $request, $id)
    {
        $params = array(
            'entry_user'=> 0,
            'approval'=> 0
        );
        $result_id = $request->input('result_id');
        $update_flg = $request->input('update_flg');

        $fishing_results_model = new FishingResults();
        $fishing_results = $fishing_results_model->find($result_id);
        $fishing_results->approval_status = $update_flg;
        $fishing_results->save();

        $entry_list = $this->get_entry_data($id);
        $event = $this->get_event($id);
        $fishing_results = $this->search_fishing_results($params, $id);

        foreach($fishing_results as $result) {
            if (!empty($result->image_data)) {
                $result_enc_img = base64_encode($result->image_data);
                $result->enc_img = $result_enc_img;
                $result_imginfo = getimagesize('data:application/octet-stream;base64,' . $result_enc_img);
                $result->imginfo = $result_imginfo['mime'];
            }
        }

        return view('approval.view')->with(compact('fishing_results', 'entry_list', 'params', 'id', 'event'));
    }

    public function delete(Request $request)
    {
        return view('approval.view')->with(compact('unapproved_fishing_results', 'approved_fishing_results', 'all_user', 'user_id'));
    }

    /**
     * 釣果を検索する
     */
    public function search_fishing_results($params, $id)
    {
        $base_query = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('fishing_results.*'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'fishing_results.image_id', '=', 'images.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->where('fishing_results.event_id', '=', $id);

        if ($params['entry_user'] != 0) {
            $base_query->where('fishing_results.user_id', '=', $params['entry_user']);
        }

        if ($params['approval'] != -1) {
            $base_query->where('fishing_results.approval_status', '=', $params['approval']);
        }

        $query_result = $base_query->get();

        return $query_result;
    }

    /**
     * エントリーリストを取得する
     */
    public function get_entry_data($id)
    {
        $query_result =
            \DB::table('entry_list')
                    ->select(
                            \DB::raw('entry_list.*'),
                            \DB::raw('users.name as user_name'),
                    )
                    ->join('users', 'entry_list.user_id', '=', 'users.id')
                    ->where('entry_list.event_id', '=', $id)
                    ->where('entry_list.cancel_flg', '=', 0)
                    ->get();

        return $query_result;
    }

    /**
     * イベントを取得する
     */
    public function get_event($id)
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('case
                            when event.start_at > NOW() then 0
                            when event.start_at <= NOW() and NOW() <= event.end_at then 1
                            when event.end_at < NOW() then 2
                            end as event_status'),
                )
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->where('event.id', '=', $id)
                ->get()
                ->first();

        return $query_result;
    }

}
