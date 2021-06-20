<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FishSpeciesRepositoryInterface;
use App\Repositories\EvaluationCriteriaRepositoryInterface;
use App\Repositories\ImagesRepositoryInterface;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\EntryListRepositoryInterface;

class EventRegistrationController extends Controller
{
    protected FishSpeciesRepositoryInterface $fishSpeciesRepository;
    protected EvaluationCriteriaRepositoryInterface $evaluationCriteriaRepository;
    protected ImagesRepositoryInterface $imagesRepository;
    protected EventRepositoryInterface $EventRepository;
    protected EntryListRepositoryInterface $EntryListRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FishSpeciesRepositoryInterface $fishSpeciesRepository
        , EvaluationCriteriaRepositoryInterface $evaluationCriteriaRepository
        , ImagesRepositoryInterface $imagesRepository
        , EventRepositoryInterface $EventRepository
        , EntryListRepositoryInterface $EntryListRepository
        )
    {
        $this->fishSpeciesRepository = $fishSpeciesRepository;
        $this->evaluationCriteriaRepository = $evaluationCriteriaRepository;
        $this->imagesRepository = $imagesRepository;
        $this->EventRepository = $EventRepository;
        $this->EntryListRepository = $EntryListRepository;
    }

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

        // 測定基準
        $evaluation_criteria_result = $this->evaluationCriteriaRepository->getEvaluationCriteriaAll();

        // 対象魚
        $fish_species_result = $this->fishSpeciesRepository->getFishSpeciesAll();
        
        return view("event-registration.view")->with(compact('evaluation_criteria_result', 'fish_species_result'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $id = $request->input('id');
        $event_name = $request->input('event_name');
        $start_at = $request->input('start_at');
        $start_at_time = $request->input('start_at_time');
        $end_at = $request->input('end_at');
        $end_at_time = $request->input('end_at_time');
        $entry_fee_flg = $request->input('entry_fee_flg');
        $note = $request->input('note');
        $evaluation_criteria = $request->input('evaluation_criteria');
        $fish_species = $request->input('fish_species');

        $start_at_datetime = $start_at . ' ' . $start_at_time . ':00';
        $end_at_datetime = $end_at . ' ' . $end_at_time . ':00';

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'event_name' => 'required|string|max:255',
            // 'start_at' => 'required|string|max:255',
            // 'end_at' => 'required|string|max:255',
            // 'entry_fee_flg' => 'required|string|max:255',
            // 'note' => 'required|string|max:255',
            // 'evaluation_criteria' => 'required|string|max:255',
            // 'fish_species' => 'required|string|max:255',
        ]);

        $image_id = $this->imagesRepository->saveImage($id, $request->pic, 2);

        $params = array(
            'id' => $id,
            'event_name' => $event_name,
            'start_at_datetime' => $start_at_datetime,
            'end_at_datetime' => $end_at_datetime,
            'evaluation_criteria' => $evaluation_criteria,
            'entry_fee_flg' => $entry_fee_flg,
            'image_id' => $image_id,
            'fish_species' => $fish_species,
            'note' => $note,
        );

        $event_id = $this->EventRepository->addEvent($params);

        $params = array(
            'id' => \Auth::user()->id,
            'event_id' => $event_id,
        );

        $this->EntryListRepository->addEntryList($params);
        
        return redirect()->route('event-management', ['id' => $id]);
    }

}
