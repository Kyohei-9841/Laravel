<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Images;
use App\FishSpecies;
use App\EvaluationCriteria;

class EventManagementController extends Controller
{
    /**
     * イベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        \Log::debug('イベント管理');

        $event_all_results = $this->get_event_all();
        $planning_event_results = $this->get_planning_event();

        for ($i = 0; $i < count($event_all_results); $i++) {
            $enc_img = base64_encode($event_all_results[$i]->image_data);
            $event_all_results[$i]->enc_img = $enc_img;
            $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
            $event_all_results[$i]->imginfo = $imginfo['mime'];            
        }

        for ($i = 0; $i < count($planning_event_results); $i++) {
            $enc_img = base64_encode($planning_event_results[$i]->image_data);
            $planning_event_results[$i]->enc_img = $enc_img;
            $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
            $planning_event_results[$i]->imginfo = $imginfo['mime'];            
        }

        return view("event-management.view")->with(compact('event_all_results', 'planning_event_results'));
    }

    /**
     * 企画イベントを取得する
     */
    public function get_planning_event()
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('case
                            when event.start_at > NOW() then 0
                            when event.start_at <= NOW() and NOW() <= event.end_at then 1
                            when event.end_at < NOW() then 2
                            end as event_status'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->where('event.user_id', '=', \Auth::user()->id)
                ->get();

        return $query_result;
    }

    /**
     * 全てのイベントを取得する
     */
    public function get_event_all()
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('entry_list', 'event.id', '=', 'entry_list.event_id')
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $query_result;
    }
}
