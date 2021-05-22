<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\FishingResults;

class ApprovalController extends Controller
{
    public function view(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $params = array(
            'entry_user'=> 0,
            'approval'=> 0
        );

        $entry_list = $this->get_entry_data($id);
        $event = $this->get_event($id);
        $fishing_results = $this->search_fishing_results($params, $id);

        if (count($fishing_results) != 0) {
            foreach($fishing_results as $result) {
                $result = Utility::isProcessingImages($result);
            }
        }

        return view('approval.view')->with(compact('fishing_results', 'entry_list', 'params', 'id', 'event'));
    }

    public function search(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $params = array(
            'entry_user'=>$request->input('entry-user'),
            'approval'=>$request->input('approval')
        );

        $entry_list = $this->get_entry_data($id);
        $event = $this->get_event($id);
        $fishing_results = $this->search_fishing_results($params, $id);

        if (count($fishing_results) != 0) {
            foreach($fishing_results as $result) {
                $result = Utility::isProcessingImages($result);
            }
        }

        return view('approval.view')->with(compact('fishing_results', 'entry_list', 'params', 'id', 'event'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
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

        return redirect()->route('approval', ['id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return redirect()->route('approval', ['id' => $id]);
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
