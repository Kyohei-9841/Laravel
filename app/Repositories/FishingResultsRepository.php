<?php

namespace App\Repositories;

use App\Models\FishingResults;
use App\Models\Images;

class fishingResultsRepository implements FishingResultsRepositoryInterface
{
    protected $fishingResultsModel;
    protected $imagesModel;

    /**
    * @param object $user
    */
    public function __construct(FishingResults $fishingResultsModel, Images $imagesModel)
    {
        $this->fishingResultsModel = $fishingResultsModel;
        $this->imagesModel = $imagesModel;
    }

    /**
     * ユーザーの釣果をイベント単位で検索する
     */
    public function searchResultForEvent($id, $params)
    {
        $selected_id = $params['selected_id'];

        $query = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('event.event_name as event_name'),
                        \DB::raw('event.measurement as measurement'),
                        \DB::raw('case
                        when event.measurement = 1 then fishing_results.size
                        when event.measurement = 2 then fishing_results.amount
                        when event.measurement = 3 then fishing_results.weight
                        end as measurement_result'),
                        \DB::raw('fishing_results.*')
                )
                ->join('images', function ($join) {
                    $join->on('fishing_results.image_id', '=', 'images.id')
                         ->where('images.registration_flg', '=', 2);
                })
                ->join('event', 'fishing_results.event_id', '=', 'event.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->where('fishing_results.user_id', '=', $id);

        if ($selected_id != 0) {
            $query->where('fishing_results.event_id', '=', $selected_id);
        }
        
        $result = $query->orderBy('fishing_results.size', 'desc')->paginate(5);

        return $result;
    }

    /**
     * 意義フラグ更新
     */
    public function updateResultMeaningfulFlg($id, $params)
    {
        $fishing_results = $this->fishingResultsModel->find($id);
        $fishing_results->update($params);
    }

    /**
     * 釣果を検索する
     */
    public function searchFishingResults($params, $id)
    {
        $base_query = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('fishing_results.*'),
                        \DB::raw('event.measurement as measurement'),
                        \DB::raw('case
                        when event.measurement = 1 then fishing_results.size
                        when event.measurement = 2 then fishing_results.amount
                        when event.measurement = 3 then fishing_results.weight
                        end as measurement_result'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'fishing_results.image_id', '=', 'images.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->join('users', 'fishing_results.user_id', '=', 'users.id')
                ->join('event', 'fishing_results.event_id', '=', 'event.id')
                ->where('fishing_results.event_id', '=', $id);

        if ($params['entry_user'] != 0) {
            $base_query->where('fishing_results.user_id', '=', $params['entry_user']);
        }

        if ($params['approval'] != -1) {
            $base_query->where('fishing_results.approval_status', '=', $params['approval']);
        }

        $result = $base_query->get();

        return $result;
    }

    /**
     * 承認ステータスを更新
     */
    public function updateApprovalStatus($result_id, $update_flg)
    {
        $fishing_results = $this->fishingResultsModel->find($result_id);
        $fishing_results->approval_status = $update_flg;
        $fishing_results->meaningful_flg = 0;
        $fishing_results->save();
    }

    /**
     * 釣果結果を登録
     */
    public function addFishingResults($params, $measurement)
    {
        $fishing_results = new FishingResults();
        $fishing_results->user_id = $params['id'];
        $fishing_results->event_id = $params['event_id'];
        $fishing_results->fish_species = $params['fish_species'];
        $fishing_results->image_id = $params['image_id'];
        $fishing_results->approval_status = 0;
        $fishing_results->latitude = $params['latitude'];
        $fishing_results->longitude = $params['longitude'];
        if ($measurement == 1) {
            $fishing_results->size = $params['measurement_result'];
            $fishing_results->amount = 1;
        } else if ($measurement == 2) {
            $fishing_results->amount = $params['measurement_result'];
        } else if ($measurement == 3) {
            $fishing_results->weight = $params['measurement_result'];
            $fishing_results->amount = 1;
        }

        $fishing_results->save();

        return $fishing_results->id;
    }

    /**
     * ユーザーの釣果情報を取得
     */
    public function getFishingResultsUser($id)
    {
        $result = \DB::table('fishing_results')
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

        return $result;

    }

    /**
     * 釣果結果を削除
     */
    public function deleteFishingResults($id)
    {
        $fishing_results = $this->fishingResultsModel->find($id);
        $images = $this->imagesModel->find($fishing_results->image_id);
        $images->delete();
        $fishing_results->delete();
    }

    /**
     * ランキングを取得
     */
    public function getRanking($id, $measurement)
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
                    \DB::raw('DISTINCT ' . $distinct . '(fr_sub_sub.' . $column_name . ') as measurement_result'),
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


        $result = \DB::table(\DB::raw('(' . $aggregate_query . ') as ft'))
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

        return $result;

    }
}