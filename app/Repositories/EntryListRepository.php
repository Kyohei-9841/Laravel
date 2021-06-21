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
     * エントリーリストを取得
     */
    public function getEntryList($id)
    {
        $result = \DB::table('entry_list')
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

    /**
     * エントリーステータスを取得する
     */
    public function addEntryStatus($id)
    {
        $result = \DB::table('entry_list')
                ->select(
                        \DB::raw('count(entry_list.id) as entry_status'),
                )
                ->where('entry_list.event_id', '=', $id)
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->get()
                ->first();

        return $result;
    }

    /**
     * エントリーを削除
     */
    public function deleteEntryList($id)
    {
        $entry_list = $entryListModel->where('event_id', '=', $id);
        $entry_list->delete();
    }

    /**
     * エントリーリストとエントリーされてるかを取得する
     */
    public function getEntryData($id)
    {
        $base_query = 
            \DB::table('entry_list')
                    ->select(
                            \DB::raw('entry_list.*'),
                    )
                    ->where('entry_list.event_id', '=', $id)
                    ->where('entry_list.cancel_flg', '=', 0);
        
        $entry_list = $base_query->get();

        $entry_flg = false;

        $entry_user = $base_query->where('entry_list.user_id', '=', \Auth::user()->id)->get()->first();

        if (!empty($entry_user)) {
            $entry_flg = true;
        }

        $result = array(
            "entry_list" => $entry_list,
            "entry_flg" => $entry_flg
        );
        return $result;

    }
}