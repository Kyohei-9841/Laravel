<?php

namespace App\Http\Controllers\EventEntry\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\EntryList;
use App\Http\Controllers\Controller;

class EventEntryController extends Controller
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
        
        \Log::debug('エントリー');
        \Log::debug($id);

        $entry_list = $this->get_entry_list($id);
        $event_info = $this->get_event($id);
        $measurement_flg = $event_info->measurement;

        $fishing_results = $this->get_fishing_results($id);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
        }

        $ranking = $this->get_ranking($id, $measurement_flg);

        $rank = 0;
        if (count($ranking) != 0) {
            foreach($ranking as $result) {
                if ($result->user_id == \Auth::user()->id) {
                    $rank = $result->rank;
                }
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view("event-entry.admin.view")->with(compact('id', 'ranking', 'entry_list', 'rank', 'fishing_results', 'measurement_flg', 'event_info'));
    }

    public function delete(Request $request, $id)
    {
        $event_id = $request->input('event_id');

        $fishing_results_model = new FishingResults();
        $fishing_results = $fishing_results_model->find($id);
        $fishing_results->delete();

        return redirect()->route('event-entry-admin', ['id' => $event_id]);
    }

    /**
     * エントリーリストを取得する
     */
    public function get_entry_list($id)
    {
        $query_result = \DB::table('entry_list')
                ->select(
                        \DB::raw('entry_list.*'),
                        \DB::raw('event.measurement as measurement'),
                )
                ->join('event', 'entry_list.event_id', '=', 'event.id')
                ->where('event.id', '=', $id)
                ->where('entry_list.cancel_flg', '=', 0)
                ->get();
        return $query_result;
    }

    /**
     * 順位を取得する
     */
    public function get_ranking($id, $measurement)
    {
        $column_name = "";
        if ($measurement == 1) {
            $column_name = "size";
            $distinct = "max";
        } else if ($measurement == 2) {
            $column_name = "amount";
            $distinct = "sum";
        } else {
            $column_name = "weight";
            $distinct = "max";
        }

        $aggregate_query = \DB::table(\DB::raw('fishing_results as max_ft'))
                ->select(
                    \DB::raw($distinct . '(max_ft.' . $column_name . ') as measurement_result'),
                    \DB::raw('max_ft.user_id as user_id'),
                )
                ->whereRaw('max_ft.approval_status = 1')
                ->where('max_ft.event_id', '=', ':event_id')
                ->groupBy('max_ft.user_id')
                ->toSql();

        $rank_sub_query = \DB::table(\DB::raw('fishing_results as fr_sub_sub'))
                ->select(
                    \DB::raw('DISTINCT ' . $distinct . '(fr_sub_sub.' . $column_name .') as measurement_result'),
                )
                ->whereRaw('fr_sub_sub.approval_status = 1')
                ->where('fr_sub_sub.event_id', '=', ':event_id_2')
                ->groupBy('fr_sub_sub.user_id')
                ->toSql();


        $rank_query = \DB::table(\DB::raw('(' . $rank_sub_query . ') as fr_sub'))
                ->select(
                    \DB::raw('COUNT(*) + 1'),
                )
                ->whereRaw('fr_sub.measurement_result > ft.measurement_result')
                ->toSql();


        $query_result = \DB::table(\DB::raw('(' . $aggregate_query . ') as ft'))
                ->select(
                        \DB::raw('ft.*'),
                        \DB::raw('users.name as user_name'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('(' . $rank_query . ') as rank')
                )
                ->join('users', 'ft.user_id', '=', 'users.id')
                ->leftJoin('images', function ($join) {
                    $join->on('users.id', '=', 'images.user_id')
                        ->whereRaw('images.registration_flg = 3');
                })
                ->orderBy('ft.measurement_result', 'desc')
                ->setBindings([':event_id'=>$id, ':event_id_2'=>$id])
                ->get();
                // \Log::debug($query_result);

        return $query_result;
    }

    /**
     * イベント情報を取得する
     */
    public function get_event($id)
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('users.name as user_name'),
                        // \DB::raw('im2.image_data as user_image_data'),
                        \DB::raw('NOW() as now_date'),
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
                // ->join('images as im2', 'users.image_id', '=', 'im2.id')
                ->where('event.id', '=', $id)
                ->get()
                ->first();

        return $query_result;
    }

    /**
     * ユーザーの釣果を取得する
     */
    public function get_fishing_results($id)
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('event.measurement as measurement'),
                        \DB::raw('case
                        when event.measurement = 1 then fishing_results.size
                        when event.measurement = 2 then fishing_results.amount
                        when event.measurement = 3 then fishing_results.weight
                        end as measurement_result'),
                        \DB::raw('fishing_results.*')
                )
                ->join('images', 'fishing_results.image_id', '=', 'images.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->join('event', 'fishing_results.event_id', '=', 'event.id')
                ->where('fishing_results.user_id', '=', \Auth::user()->id)
                ->where('event.id', '=', $id)
                ->get();

        return $query_result;
    }
}
