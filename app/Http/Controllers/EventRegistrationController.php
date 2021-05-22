<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\EvaluationCriteria;
use App\FishSpecies;
use App\Images;
use App\Event;

class EventRegistrationController extends Controller
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
        // $user = User::find($id);

        // 測定基準
        $evaluation_criteria = new EvaluationCriteria();
        $evaluation_criteria_result = $evaluation_criteria->get();

        // 魚種
        $fish_species = new FishSpecies();
        $fish_species_result = $fish_species->get();

        return view("event-registration.view")->with(compact('evaluation_criteria_result', 'fish_species_result'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('イベント：保存');
        \Log::debug($request->input('pic'));

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

        \Log::debug('アップロード：1');
        \Log::debug("id");
        \Log::debug($id);
        \Log::debug("event_name");
        \Log::debug($event_name);
        \Log::debug("start_at");
        \Log::debug($start_at);
        \Log::debug("start_at_time");
        \Log::debug($start_at_time);
        \Log::debug("end_at");
        \Log::debug($end_at);
        \Log::debug("end_at_time");
        \Log::debug($end_at_time);
        \Log::debug("entry_fee_flg");
        \Log::debug($entry_fee_flg);
        \Log::debug("note");
        \Log::debug($note);
        \Log::debug("evaluation_criteria");
        \Log::debug($evaluation_criteria);
        \Log::debug("fish_species");
        \Log::debug($fish_species);

        $start_at_datetime = $start_at . ' ' . $start_at_time . ':00';
        $end_at_datetime = $end_at . ' ' . $end_at_time . ':00';
        \Log::debug($start_at_datetime);
        \Log::debug($end_at_datetime);

        // $request->validate([
        //     'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        //     'event_name' => 'required|string|max:255',
        //     'start_at' => 'required|string|max:255',
        //     'end_at' => 'required|string|max:255',
        //     'entry_fee_flg' => 'required|string|max:255',
        //     'note' => 'required|string|max:255',
        //     'evaluation_criteria' => 'required|string|max:255',
        //     'fish_species' => 'required|string|max:255',
        // ]);
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

        $event = new Event();
        $event->user_id = $id;
        $event->event_name = $event_name;
        $event->start_at = $start_at_datetime;
        $event->end_at = $end_at_datetime;
        $event->measurement = $evaluation_criteria;
        $event->entry_fee_flg = $entry_fee_flg;
        $event->image_id = $image_id;
        $event->fish_species = $fish_species;
        $event->note = $note;
        $event->save();

        return redirect()->route('event-management', ['id' => $id]);
    }

}
