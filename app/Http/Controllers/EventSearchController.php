<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\FishSpeciesRepositoryInterface;
use App\Repositories\EvaluationCriteriaRepositoryInterface;

class EventSearchController extends Controller
{
    protected EventRepositoryInterface $eventRepository;
    protected FishSpeciesRepositoryInterface $fishSpeciesRepository;
    protected EvaluationCriteriaRepositoryInterface $evaluationCriteriaRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $eventRepository, FishSpeciesRepositoryInterface $fishSpeciesRepository, EvaluationCriteriaRepositoryInterface $evaluationCriteriaRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->fishSpeciesRepository = $fishSpeciesRepository;
        $this->evaluationCriteriaRepository = $evaluationCriteriaRepository;
    }

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
        $evaluation_criteria_result = $this->evaluationCriteriaRepository->getEvaluationCriteriaAll();

        // 対象魚
        $fish_species_result = $this->fishSpeciesRepository->getFishSpeciesAll();

        $params = array(
            'event_name'=> null,
            'start_at'=> date("Y-m-d"),
            'start_at_time'=> '00:00',
            'end_at'=> null,
            'end_at_time'=> null,
            'evaluation_criteria'=> null,
            'fish_species'=> null,
        );

        $event_all_results = $this->eventRepository->searchEvent($params);

        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
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

        $event_all_results = $this->eventRepository->searchEvent($params);

        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        // 測定基準
        $evaluation_criteria_result = $this->evaluationCriteriaRepository->getEvaluationCriteriaAll();

        // 対象魚
        $fish_species_result = $this->fishSpeciesRepository->getFishSpeciesAll();

        return view("event-search.view")->with(compact('event_all_results', 'evaluation_criteria_result', 'fish_species_result', 'params'));
    }
}
