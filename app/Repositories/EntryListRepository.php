<?php

namespace App\Repositories;

use App\Models\EntryList;

class EntryListRepository implements EntryListRepositoryInterface
{
    protected $entryListModel;

    /**
    * @param object $user
    */
    public function __construct(EntryList $entryListModel)
    {
        $this->entryListModel = $entryListModel;
    }

    /**
     * 開催中のイベントを取得
     */
    public function getEventHeld()
    {
        $result = \DB::table('event')
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

        return $result;
    }

    /**
     * エントリーリストを登録する
     */
    public function addEntryList($params)
    {
        $entryList = new EntryList;
        $entryList->user_id = $params['id'];
        $entryList->event_id = $params['event_id'];
        $entryList->cancel_flg = 0;
        $entryList->cancel_date = null;
        $entryList->save();
    }
}