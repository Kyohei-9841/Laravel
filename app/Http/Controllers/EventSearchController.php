<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Event;
use App\Images;
use App\FishSpecies;
use App\EvaluationCriteria;

class EventSearchController extends Controller
{
    /**
     * イベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('イベント検索');

        // 測定基準
        $evaluation_criteria = new EvaluationCriteria();
        $evaluation_criteria_result = $evaluation_criteria->get();

        // 魚種
        $fish_species = new FishSpecies();
        $fish_species_result = $fish_species->get();

        $params = array(
            'event_name'=> null,
            'start_at'=> date("Y-m-d"),
            'start_at_time'=> '00:00',
            'end_at'=> null,
            'end_at_time'=> null,
            'evaluation_criteria'=> null,
            'fish_species'=> null,
        );

        $event_all_results = $this->search_event($params);

        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isProcessingImages($result);
            }
        }

        return view("event-search.view")->with(compact('event_all_results', 'evaluation_criteria_result', 'fish_species_result', 'params'));
    }

    /**
     * 検索
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('イベント検索実行');

        $request_data = $request->all();

        $event_name = data_get($request_data, 'event-name');
        $start_at = data_get($request_data, 'start-at');
        $start_at_time = data_get($request_data, 'start-at-time');
        $end_at = data_get($request_data, 'end-at');
        $end_at_time = data_get($request_data, 'end-at-time');
        $evaluation_criteria = data_get($request_data, 'evaluation-criteria');
        $fish_species = data_get($request_data, 'fish-species');

        $params = array(
            'event_name'=> $event_name,
            'start_at'=> $start_at,
            'start_at_time'=> $start_at_time,
            'end_at'=> $end_at,
            'end_at_time'=> $end_at_time,
            'evaluation_criteria'=> $evaluation_criteria,
            'fish_species'=> $fish_species,
        );

        $event_all_results = $this->search_event($params);

        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isProcessingImages($result);
            }
        }

        // 測定基準
        $evaluation_criteria = new EvaluationCriteria();
        $evaluation_criteria_result = $evaluation_criteria->get();

        // 魚種
        $fish_species = new FishSpecies();
        $fish_species_result = $fish_species->get();

        return view("event-search.view")->with(compact('event_all_results', 'evaluation_criteria_result', 'fish_species_result', 'params'));
    }

    /**
     * イベントを検索する
     */
    public function search_event($params)
    {
        $event_name = $params['event_name'];
        $start_at = $params['start_at'];
        $start_at_time = $params['start_at_time'];
        $end_at = $params['end_at'];
        $end_at_time = $params['end_at_time'];
        $evaluation_criteria = $params['evaluation_criteria'];
        $fish_species = $params['fish_species'];

        $event_name_search = '%' . $event_name . '%';
        $start_at_datetime;
        $end_at_datetime;
        \Log::debug($event_name_search);

        if (!empty($start_at)) {
            if (!empty($start_at_time)) {
                $start_at_datetime = $start_at . ' ' . $start_at_time . ':00';

            } else {
                $start_at_datetime = $start_at . '00:00:00';
            }
        }

        if (!empty($end_at)) {
            if (!empty($end_at_time)) {
                $end_at_datetime = $end_at . ' ' . $end_at_time . ':00';
            } else {
                $end_at_datetime = $end_at . '00:00:00';
            }
        }

        $query = \DB::table('event')
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
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id');

        if (!empty($event_name)) {
            $query->where('event.event_name', 'like', $event_name_search);
        }

        if (!empty($start_at_datetime) && !empty($end_at_datetime)) {
            $query->where('event.start_at', '>=', $start_at_datetime);
            $query->where('event.end_at', '<=', $end_at_datetime);
        } else if (!empty($start_at_datetime)) {
            $query->where('event.start_at', '>=', $start_at_datetime);
        } else if (!empty($end_at_datetime)) {
            $query->where('event.end_at', '<=', $end_at_datetime);
        }

        if ($evaluation_criteria != 0) {
            $query->where('event.measurement', '=', $evaluation_criteria);
        }

        if ($fish_species != 0) {
            $query->where('event.fish_species', '=', $fish_species);
        }

        $query_result = $query->orderBy('event.start_at', 'desc')->get();

        return $query_result;
    }
}
