<?php

namespace App\Http\Controllers\EventEntry;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Models\EntryList;
use App\Models\FishingResults;
use App\Models\Images;
use App\Http\Controllers\Controller;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\FishingResultsRepositoryInterface;
use App\Repositories\EntryListRepositoryInterface;

class EventEntryController extends Controller
{

    protected EventRepositoryInterface $eventRepository;
    protected FishingResultsRepositoryInterface $fishingResultsRepository;
    protected EntryListRepositoryInterface $entryListRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EventRepositoryInterface $eventRepository
        , FishingResultsRepositoryInterface $fishingResultsRepository
        , EntryListRepositoryInterface $entryListRepository
        )
    {
        $this->eventRepository = $eventRepository;
        $this->fishingResultsRepository = $fishingResultsRepository;
        $this->entryListRepository = $entryListRepository;
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
        
        \Log::debug('エントリー');
        \Log::debug($id);

        Utility::isPresenceOrAbsenceOfFolder();

        $entry_data = $this->entryListRepository->getEntryData($id);

        $entry_list = $entry_data['entry_list'];
        $entry_flg = $entry_data['entry_flg'];

        $event_info = $this->eventRepository->getEventInfo($id);

        $fishing_results = $this->fishingResultsRepository->getFishingResultsUser($id);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
        }

        $measurement_flg = $event_info->measurement;

        $ranking = $this->fishingResultsRepository->getRanking($id, $measurement_flg);

        $rank = 0;
        if (count($ranking) != 0) {
            foreach($ranking as $ranking_data) {
                if ($ranking_data->user_id == \Auth::user()->id) {
                    $rank = $ranking_data->rank;
                }
                $ranking_data = Utility::isDirectDisplayImages($ranking_data);
            }
        }

        return view("event-entry.view")->with(compact('id', 'entry_flg', 'event_info', 'fishing_results', 'ranking', 'entry_list', 'rank', 'measurement_flg'));
    }

    /**
     * エントリー
     * @return \Illuminate\Http\Response
     */
    public function entry(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('エントリー');
        \Log::debug($id);

        $params = array(
            'id' => \Auth::user()->id,
            'event_id' => $id,
        );

        $this->entryListRepository->addEntryList($params);

        return redirect()->route('event-entry', ['id' => $id]);
    }

    public function delete(Request $request, $id)
    {
        $event_id = $request->input('event_id');

        $this->fishingResultsRepository->deleteFishingResults($id);

        return redirect()->route('event-entry', ['id' => $event_id]);
    }
}
