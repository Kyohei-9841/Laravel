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

        $ranking = $this->get_ranking($id, $entry_list[0]->measurement);

        if (count($ranking) != 0) {
            foreach($ranking as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view("event-entry.admin.view")->with(compact('id', 'ranking'));
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

}
