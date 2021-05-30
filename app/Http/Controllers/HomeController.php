<?php

namespace App\Http\Controllers;

use App\Utils\Utility;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $event_all = $this->get_event_all();
        $event_finish = $this->get_event_finish();

        if (count($event_all) != 0) {
            foreach($event_all as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_finish) != 0) {
            foreach($event_finish as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view('home')->with(compact('event_all', 'event_finish'));
    }

    /**
     * 企画イベントを取得する
     */
    public function get_event_all()
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
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $query_result;
    }

    /**
     * 企画イベントを取得する
     */
    public function get_event_finish()
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
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $query_result;
    }
}
