<?php

namespace App\Http\Controllers\Upload\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\FishingResults;
use App\Images;
use App\Event;
use App\FishSpecies;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

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
        $event_data = $event_model->find($event_id);

        // 対象魚
        $fish_species_model = new FishSpecies();
        $fish_species_data = $fish_species_model->get();

        return view("upload.admin.view")->with(compact('id', 'event_id', 'event_data', 'fish_species_data'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        \Log::debug('アップロード：保存');
        \Log::debug($request->input('id'));
        \Log::debug($request->input('measurement'));
        \Log::debug($request->input('fish_species'));
        \Log::debug($request->input('measurement_result'));
        \Log::debug($request->input('pic'));
        \Log::debug($request->input('latitude'));
        \Log::debug($request->input('longitude'));

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

        // $now_date_ymd = date("Y_m_d");
        // $now_date_his = date("H_i_s");
        // \Log::debug($request->pic);

        // $img_url = $request->pic->storeAs('public/upload/' . $id . $now_date_ymd, $id . '_' . $now_date_his . '.jpg');
        // \Log::debug($img_url);

        $images = new Images();
        $images->user_id = $id;
        $images->registration_flg = 2;
        $images->image_data = file_get_contents($request->pic);
        $images->save();

        $image_id = $images->id;

        \Log::debug('ここ通ってるか');

        $fishing_results = new FishingResults();
        $fishing_results->user_id = $id;
        $fishing_results->event_id = $event_id;
        // $fishing_results->position = $position;
        $fishing_results->fish_species = $fish_species;
        // $fishing_results->pic = $img_url;
        $fishing_results->image_id = $image_id;
        $fishing_results->approval_status = 0;
        $fishing_results->latitude = $latitude;
        $fishing_results->longitude = $longitude;
        if ($measurement == 1) {
            $fishing_results->size = $measurement_result;
            $fishing_results->amount = 1;
        } else if ($measurement == 2) {
            $fishing_results->amount = $measurement_result;
        } else if ($measurement == 3) {
            $fishing_results->weight = $measurement_result;
            $fishing_results->amount = 1;
        }

        $fishing_results->save();

        $fishing_results_id = $fishing_results->id;

        $result = [
            'result' => $fishing_results_id,
            'message' => 'OK'
        ];
        // return redirect()->route('profile', ['id' => $id]);
        return response()->json($result, '200', ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }

     /**
     * イベント情報を取得する
     */
    public function get_event_all()
    {
        $query_result = \DB::table('event')
                ->select(\DB::raw('event.*'))
                ->join('entry_list', function ($join) {
                    $join->on('event.id', '=', 'entry_list.event_id')
                        ->where('entry_list.user_id', '=', \Auth::user()->id);
                })
                ->whereRaw('event.start_at <= NOW()')
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $query_result;
    }
}
