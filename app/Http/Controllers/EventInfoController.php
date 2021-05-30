<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Utility;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Images;
use App\FishSpecies;
use App\EvaluationCriteria;

class EventInfoController extends Controller
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
        
        \Log::debug('イベント詳細');
        \Log::debug($id);

        $event_info = $this->get_event($id);

        $event_info = Utility::isDirectDisplayImages($event_info);

        $admin_flg = false;

        if ($event_info->user_id == \Auth::user()->id) {
            $admin_flg = true;
        }

        $entry_status = $this->get_entry_status($id);

        $entry_list = $this->get_entry_list($id);

        if (count($entry_list) != 0) {
            foreach($entry_list as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        // $user_enc_img = base64_encode($event_info->user_image_data);
        // $event_info->user_enc_img = $user_enc_img;
        // $user_imginfo = getimagesize('data:application/octet-stream;base64,' . $user_enc_img);
        // $event_info->user_imginfo = $user_imginfo['mime'];

        return view("event-info.view")->with(compact('id', 'event_info', 'admin_flg', 'entry_status', 'entry_list'));
    }

    /**
     * 一般向けのイベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function viewGeneral(Request $request, $id)
    {        
        \Log::debug('イベント詳細');
        \Log::debug($id);

        $event_info = $this->get_event($id);

        $event_info = Utility::isDirectDisplayImages($event_info);

        return view("event-info.general-page.view")->with(compact('event_info'));
    }

    /**
     * イベントを取得する
     */
    public function get_event($id)
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
                ->where('event.id', '=', $id)
                ->get()
                ->first();

        return $query_result;
    }

    /**
     * エントリーしてるかのステータスを取得する
     */
    public function get_entry_status($id)
    {
        $query_result = \DB::table('entry_list')
                ->select(
                        \DB::raw('count(entry_list.id) as entry_status'),
                )
                ->where('entry_list.event_id', '=', $id)
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->get()
                ->first();

        return $query_result;
    }

    /**
     * エントリーリストを取得する
     */
    public function get_entry_list($id)
    {
        $query_result = \DB::table('entry_list')
                ->select(
                        \DB::raw('entry_list.*'),
                        \DB::raw('users.name as user_name'),
                        \DB::raw('images.image_data as image_data'),
                )
                ->join('event', 'entry_list.event_id', '=', 'event.id')
                ->join('users', 'entry_list.user_id', '=', 'users.id')
                ->leftJoin('images', function ($join) {
                    $join->on('users.image_id', '=', 'images.id')
                        ->whereRaw('images.registration_flg = 3');
                })
                ->where('event.id', '=', $id)
                ->where('entry_list.cancel_flg', '=', 0)
                ->get();

        return $query_result;
    }
}
