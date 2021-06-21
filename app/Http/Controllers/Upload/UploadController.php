<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\ImagesRepositoryInterface;
use App\Repositories\FishingResultsRepositoryInterface;
use App\Repositories\FishSpeciesRepositoryInterface;

class UploadController extends Controller
{

    protected EventRepositoryInterface $eventRepository;
    protected ImagesRepositoryInterface $imagesRepository;
    protected FishingResultsRepositoryInterface $fishingResultsRepository;
    protected FishSpeciesRepositoryInterface $fishSpeciesRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EventRepositoryInterface $eventRepository
        , ImagesRepositoryInterface $imagesRepository
        , FishingResultsRepositoryInterface $fishingResultsRepository
        , FishSpeciesRepositoryInterface $fishSpeciesRepository
        )
    {
        $this->eventRepository = $eventRepository;
        $this->imagesRepository = $imagesRepository;
        $this->fishingResultsRepository = $fishingResultsRepository;
        $this->fishSpeciesRepository = $fishSpeciesRepository;
    }

    /**
     * アップロード画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        \Log::debug('アップロード1');

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        \Log::debug('アップロード');
        \Log::debug($request->input('measurement'));

        $event_id = $request->input('event_id');

        $event_model = new Event();
        $event_list = $this->eventRepository->getEventAllUserUpload();

        $event_data = null;

        if (count($event_list) != 0) {
            $search_event_id = empty($event_id) ? $event_list[0]->id : $event_id;
            $event_data = $event_model->find($search_event_id);
        }

        // 対象魚
        $fish_species_data = $this->fishSpeciesRepository->getFishSpeciesAll();

        return view("upload.view")->with(compact('id', 'event_id', 'event_data', 'fish_species_data', 'event_list'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('アップロード：保存');
        $id = $request->input('id');
        $event_id = $request->input('event_id');
        $measurement = $request->input('measurement');
        $fish_species = $request->input('fish_species');
        $measurement_result = $request->input('measurement_result');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        \Log::debug('アップロード：1');

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            // 'position' => 'required|string|max:255',
            'fish_species' => 'required|string|max:255',
            'measurement_result' => 'required|string|max:255',
            // 'latitude' => 'required|string|max:255',
            // 'longitude' => 'required|string|max:255',

        ]);
        \Log::debug('アップロード：2');

        $image_id = $this->imagesRepository->saveImage($id, $request->pic, 2);

        \Log::debug('ここ通ってるか');

        $params = array(
            'id'=> $id,
            'event_id'=> $event_id,
            'fish_species'=> $fish_species,
            'image_id'=> $image_id,
            'latitude'=> $latitude,
            'longitude'=> $longitude,
            'measurement_result'=> $measurement_result,
        );

        $fishing_results_id = $this->fishingResultsRepository->addFishingResults($params, $measurement);

        $result = [
            'result' => $fishing_results_id,
            'message' => 'OK'
        ];
        // return redirect()->route('profile', ['id' => $id]);
        return response()->json($result, '200', ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }
}
