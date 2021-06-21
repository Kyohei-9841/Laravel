<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Repositories\EntryListRepositoryInterface;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\FishingResultsRepositoryInterface;

class ApprovalController extends Controller
{

    protected EventRepositoryInterface $eventRepository;
    protected EntryListRepositoryInterface $EntryListRepository;
    protected FishingResultsRepositoryInterface $fishingResultsRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EventRepositoryInterface $eventRepository
        , EntryListRepositoryInterface $EntryListRepository
        , FishingResultsRepositoryInterface $fishingResultsRepository
        )
    {
        $this->eventRepository = $eventRepository;
        $this->EntryListRepository = $EntryListRepository;
        $this->fishingResultsRepository = $fishingResultsRepository;

    }

    public function view(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $params = array(
            'entry_user'=> 0,
            'approval'=> 0
        );

        $entry_list = $this->EntryListRepository->getEntryList($id);

        $event = $this->eventRepository->getEventInfo($id);

        $fishing_results = $this->fishingResultsRepository->searchFishingResults($params, $id);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
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

        $entry_list = $this->EntryListRepository->getEntryList($id);

        $event = $this->eventRepository->getEventInfo($id);

        $fishing_results = $this->fishingResultsRepository->searchFishingResults($params, $id);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
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

        $this->fishingResultsRepository->updateApprovalStatus($result_id, $update_flg);

        return redirect()->route('approval', ['id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return redirect()->route('approval', ['id' => $id]);
    }
}
