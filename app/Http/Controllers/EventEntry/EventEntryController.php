<?php

namespace App\Http\Controllers\EventEntry;

use Illuminate\Http\Request;
use App\EntryList;
use App\Http\Controllers\Controller;

class EventEntryController extends Controller
{
    /**
     * イベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        \Log::debug('エントリー');
        \Log::debug($id);

        $entry_data = $this->get_entry_data($id);
        $entry_list = $entry_data['entry_list'];
        $entry_flg = $entry_data['entry_flg'];

        $event_info = $this->get_event($id);

        $enc_img = base64_encode($event_info->image_data);
        $event_info->enc_img = $enc_img;
        $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
        $event_info->imginfo = $imginfo['mime'];


        $fishing_results = $this->get_fishing_results($id);

        foreach($fishing_results as $result) {
            if (!empty($result->image_data)) {
                $enc_img = base64_encode($result->image_data);
                $result->enc_img = $enc_img;
                $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
                $result->imginfo = $imginfo['mime'];
            }
        }

        $ranking = $this->get_ranking($id);

        $rank = 0;
        foreach($ranking as $ranking_data) {
            if ($ranking_data->user_id == \Auth::user()->id) {
                $rank = $ranking_data->rank;
            }
            if (!empty($ranking_data->image_data)) {
                $result_enc_img = base64_encode($ranking_data->image_data);
                $ranking_data->enc_img = $result_enc_img;
                $result_imginfo = getimagesize('data:application/octet-stream;base64,' . $result_enc_img);
                $ranking_data->imginfo = $result_imginfo['mime'];
            }
        }

        return view("event-entry.view")->with(compact('id', 'entry_flg', 'event_info', 'fishing_results', 'ranking', 'entry_list', 'rank'));
    }


    /**
     * エントリー
     * @return \Illuminate\Http\Response
     */
    public function entry(Request $request, $id)
    {
        \Log::debug('エントリー');
        \Log::debug($id);

        // エントリー
        $event_list_model = new EntryList();
        $event_list_model->user_id = \Auth::user()->id;
        $event_list_model->event_id = $id;
        $event_list_model->cancel_flg = 0;
        $event_list_model->cancel_date = null;
        $event_list_model->save();

        return redirect()->route('event-entry', ['id' => $id]);
    }


    /**
     * エントリーリストとエントリーされてるかを取得する
     */
    public function get_entry_data($id)
    {
        $base_query = 
            \DB::table('entry_list')
                    ->select(
                            \DB::raw('entry_list.*'),
                    )
                    ->where('entry_list.event_id', '=', $id)
                    ->where('entry_list.cancel_flg', '=', 0);
        
        $entry_list = $base_query->get();

        $entry_flg = false;

        $entry_user = $base_query->where('entry_list.user_id', '=', \Auth::user()->id)->get()->first();

        if (!empty($entry_user)) {
            $entry_flg = true;
        }

        $query_result = array(
            "entry_list" => $entry_list,
            "entry_flg" => $entry_flg
        );
        return $query_result;
    }

    /**
     * イベント情報を取得する
     */
    public function get_event($id)
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('users.name as user_name'),
                        // \DB::raw('im2.image_data as user_image_data'),
                        \DB::raw('NOW() as now_date'),

                        \DB::raw('case
                            when event.start_at > NOW() then 0
                            when event.start_at <= NOW() and NOW() <= event.end_at then 1
                            when event.end_at < NOW() then 2
                            end as event_status'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('users', 'event.user_id', '=', 'users.id')
                // ->join('images as im2', 'users.image_id', '=', 'im2.id')
                ->where('event.id', '=', $id)
                ->get()
                ->first();

        return $query_result;
    }

    /**
     * ユーザーの釣果を取得する
     */
    public function get_fishing_results($id)
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('images', 'fishing_results.image_id', '=', 'images.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->join('event', 'fishing_results.event_id', '=', 'event.id')
                ->where('fishing_results.user_id', '=', \Auth::user()->id)
                ->where('event.id', '=', $id)
                ->get();

        return $query_result;
    }

    /**
     * 順位を取得する
     */
    public function get_ranking($id)
    {

        $aggregate_query = \DB::table(\DB::raw('fishing_results as max_ft'))
                ->select(
                    \DB::raw('max(max_ft.size) as size'),
                    \DB::raw('max_ft.user_id as user_id'),
                )
                ->whereRaw('max_ft.approval_status = 1')
                ->where('max_ft.event_id', '=', ':event_id')
                ->groupBy('max_ft.user_id')
                ->toSql();

        $rank_sub_query = \DB::table(\DB::raw('fishing_results as fr_sub_sub'))
                ->select(
                    \DB::raw('DISTINCT max(fr_sub_sub.size) as size'),
                )
                ->whereRaw('fr_sub_sub.approval_status = 1')
                ->where('fr_sub_sub.event_id', '=', ':event_id_2')
                ->groupBy('fr_sub_sub.user_id')
                ->toSql();


        $rank_query = \DB::table(\DB::raw('(' . $rank_sub_query . ') as fr_sub'))
                ->select(
                    \DB::raw('COUNT(*) + 1'),
                )
                ->whereRaw('fr_sub.size > ft.size')
                ->toSql();


        $query_result = \DB::table(\DB::raw('(' . $aggregate_query . ') as ft'))
                ->select(
                        \DB::raw('ft.*'),
                        \DB::raw('users.name as user_name'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('(' . $rank_query . ') as rank')
                )
                ->join('users', 'ft.user_id', '=', 'users.id')
                ->leftJoin('images', function ($join) {
                    $join->on('users.id', '=', 'images.user_id')
                        ->whereRaw('images.registration_flg = 3');
                })
                ->orderBy('ft.size', 'desc')
                ->setBindings([':event_id'=>$id, ':event_id_2'=>$id])
                ->get();

        return $query_result;
    }
}
