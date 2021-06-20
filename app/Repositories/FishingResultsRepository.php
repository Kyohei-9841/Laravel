<?php

namespace App\Repositories;

use App\Models\FishingResults;

class FishingResultsRepository implements FishingResultsRepositoryInterface
{
    protected $fishingResultsModel;

    /**
    * @param object $user
    */
    public function __construct(FishingResults $fishingResultsModel)
    {
        $this->fishingResultsModel = $fishingResultsModel;
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
     * 
     */
    public function updateResultMeaningfulFlg($id, $params)
    {
        $fishing_results = $this->fishingResultsModel->find($id);
        $fishing_results->update($params);
    }
}