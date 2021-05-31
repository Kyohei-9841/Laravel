<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('イベント管理');

        $planning_event_results = $this->get_planning_event();
        $event_all_results = $this->get_event_all();
        $planning_finish_event_results = $this->get_planning_finish_event();
        $event_finish_all_results = $this->get_event_finish_all();

        if (count($planning_event_results) != 0) {
            foreach($planning_event_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($planning_finish_event_results) != 0) {
            foreach($planning_finish_event_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_finish_all_results) != 0) {
            foreach($event_finish_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view("event-management.view")->with(compact('event_all_results', 'planning_event_results', 'planning_finish_event_results', 'event_finish_all_results'));
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
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
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
                ->join('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('event.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at >= NOW()')
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
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('entry_list', 'event.id', '=', 'entry_list.event_id')
                ->join('users', 'event.user_id', '=', 'users.id')
                ->join('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->where('event.user_id', '<>', \Auth::user()->id)
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $query_result;
    }

    /**
     * 企画イベント(終了)を取得する
     */
    public function get_planning_finish_event()
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
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
                ->join('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('event.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $query_result;
    }

    /**
     * 全てのイベント(終了)を取得する
     */
    public function get_event_finish_all()
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('entry_list', 'event.id', '=', 'entry_list.event_id')
                ->join('users', 'event.user_id', '=', 'users.id')
                ->join('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $query_result;
    }

}
