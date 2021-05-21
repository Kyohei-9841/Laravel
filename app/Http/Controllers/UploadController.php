<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FishingResults;
use App\Images;
use App\Event;
use App\FishSpecies;

class UploadController extends Controller
{

    /**
     * アップロード画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        \Log::debug('アップロード');
        \Log::debug($id);
        \Log::debug($request->input('event_id'));

        $event_model = new Event();
        $event_data = $event_model->find($request->input('event_id'));
        $event_id = $request->input('event_id');

        // 魚種
        $fish_species_model = new FishSpecies();
        $fish_species_data = $fish_species_model->get();        

        return view("upload.view")->with(compact('id', 'event_id', 'event_data', 'fish_species_data'));
    }

    public function store(Request $request)
    {
        \Log::debug('アップロード：保存');
        \Log::debug($request->input('id'));
        // \Log::debug($request->input('position'));
        \Log::debug($request->input('fish_species'));
        \Log::debug($request->input('size'));
        \Log::debug($request->input('pic'));
        \Log::debug($request->input('latitude'));
        \Log::debug($request->input('longitude'));

        $id = $request->input('id');
        $event_id = $request->input('event_id');
        // $position = $request->input('position');
        $fish_species = $request->input('fish_species');
        $size = $request->input('size');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        \Log::debug('アップロード：1');

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            // 'position' => 'required|string|max:255',
            'fish_species' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'latitude' => 'required|string|max:255',
            'longitude' => 'required|string|max:255',

        ]);
        \Log::debug('アップロード：2');

        $now_date_ymd = date("Y_m_d");
        $now_date_his = date("H_i_s");
        \Log::debug($request->pic);

        $img_url = $request->pic->storeAs('public/upload/' . $id . $now_date_ymd, $id . '_' . $now_date_his . '.jpg');
        \Log::debug($img_url);

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
        $fishing_results->size = $size;
        $fishing_results->pic = $img_url;
        $fishing_results->image_id = $image_id;
        $fishing_results->approval_status = 0;
        $fishing_results->latitude = $latitude;
        $fishing_results->longitude = $longitude;

        $fishing_results->save();

        return redirect()->route('profile', ['id' => $id]);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        \Log::debug('アップロード：削除');

        $target_data = FishingResults::find($id);

        $file_full_dir = $target_data->pic;

        $arr_file_dir = explode("/", $file_full_dir);

        $dir = $arr_file_dir[0] . "/" . $arr_file_dir[1] . "/" . $arr_file_dir[2];

        $arr_files = \Storage::files($dir);

        if (count($arr_files) == 1) {
            \Storage::deleteDirectory($dir);
        } else {
            \Storage::delete($target_data->pic);
        }

        $target_data->delete();

        return redirect()->route('fishing-results', ['id' => $id]);
    }

}
