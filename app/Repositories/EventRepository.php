<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Images;

class EventRepository implements EventRepositoryInterface
{
    protected $eventModel;
    protected $imagesModel;

    /**
    * @param object $user
    */
    public function __construct(Event $eventModel, Images $imagesModel)
    {
        $this->eventModel = $eventModel;
        $this->imagesModel = $imagesModel;

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
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $result;
    }

    /**
     * 終わったイベントを取得
     */
    public function getEventFinish()
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
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $result;
    }

    /**
     * ユーザーが参加してるイベントを取得する
     */
    public function getEventAllUser($id)
    {
        $result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                )
                ->join('entry_list', 'entry_list.event_id', '=', 'event.id')
                ->where('entry_list.user_id', '=', $id)
                ->get();

        return $result;
    }

    /**
     * ユーザーが参加してるイベントを取得する(アップロード画面用)
     */
    public function getEventAllUserUpload()
    {
        $result = \DB::table('event')
                ->select(\DB::raw('event.*'))
                ->join('entry_list', function ($join) {
                    $join->on('event.id', '=', 'entry_list.event_id')
                        ->where('entry_list.user_id', '=', \Auth::user()->id);
                })
                ->whereRaw('event.start_at <= NOW()')
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $result;

    }

    /**
     * イベントを検索する
     */
    public function searchEvent($params)
    {
        $event_name = $params['event_name'];
        $start_at = $params['start_at'];
        $start_at_time = $params['start_at_time'];
        $end_at = $params['end_at'];
        $end_at_time = $params['end_at_time'];
        $evaluation_criteria = $params['evaluation_criteria'];
        $fish_species = $params['fish_species'];

        $event_name_search = '%' . $event_name . '%';
        $start_at_datetime;
        $end_at_datetime;
        \Log::debug($event_name_search);

        if (!empty($start_at)) {
            if (!empty($start_at_time)) {
                $start_at_datetime = $start_at . ' ' . $start_at_time . ':00';

            } else {
                $start_at_datetime = $start_at . ' 00:00:00';
            }
        }

        if (!empty($end_at)) {
            if (!empty($end_at_time)) {
                $end_at_datetime = $end_at . ' ' . $end_at_time . ':00';
            } else {
                $end_at_datetime = $end_at . ' 00:00:00';
            }
        }
        \Log::debug(print_r($start_at_datetime, true));
        $query = \DB::table('event')
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
                ->leftJoin('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('users', 'event.user_id', '=', 'users.id')
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id');

        if (!empty($event_name)) {
            $query->where('event.event_name', 'like', $event_name_search);
        }

        if (!empty($start_at_datetime) && !empty($end_at_datetime)) {
            $query->where('event.start_at', '>=', $start_at_datetime);
            $query->where('event.end_at', '<=', $end_at_datetime);
        } else if (!empty($start_at_datetime)) {
            $query->where('event.start_at', '>=', $start_at_datetime);
        } else if (!empty($end_at_datetime)) {
            $query->where('event.end_at', '<=', $end_at_datetime);
        }

        if ($evaluation_criteria != 0) {
            $query->where('event.measurement', '=', $evaluation_criteria);
        }

        if ($fish_species != 0) {
            $query->where('event.fish_species', '=', $fish_species);
        }

        $result = $query->orderBy('event.start_at', 'desc')->paginate(5);

        return $result;
    }

    /**
     * イベントを登録する
     */
    public function addEvent($params)
    {
        \Log::debug(print_r($params, true));
        $event = new Event;
        $event->user_id = $params['id'];
        $event->event_name = $params['event_name'];
        $event->start_at = $params['start_at_datetime'];
        $event->end_at = $params['end_at_datetime'];
        $event->measurement = $params['evaluation_criteria'];
        $event->entry_fee_flg = $params['entry_fee_flg'];
        $event->image_id = $params['image_id'];
        $event->fish_species = $params['fish_species'];
        $event->note = $params['note'];
        $event->save();

        return $event->id;
    }

    /**
     * 参加中のイベントを取得する
     */
    public function getEventEntry()
    {
        $result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('entry_list', 'event.id', '=', 'entry_list.event_id')
                ->join('users', 'event.user_id', '=', 'users.id')
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->where('event.user_id', '<>', \Auth::user()->id)
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $result;
    }

    /**
     * 企画中のイベントを取得する
     */
    public function getEventPlanning()
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
                ->leftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('event.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at >= NOW()')
                ->get();

        return $result;
    }

    /**
     * 過去１週間で参加したイベントを取得する
     */
    public function getEventEntryFinish()
    {
        $result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
                )
                ->join('images', 'event.image_id', '=', 'images.id')
                ->join('fish_species', 'event.fish_species', '=', 'fish_species.id')
                ->join('evaluation_criteria', 'event.measurement', '=', 'evaluation_criteria.id')
                ->join('entry_list', 'event.id', '=', 'entry_list.event_id')
                ->join('users', 'event.user_id', '=', 'users.id')
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('entry_list.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $result;
    }

    /**
     * 過去１週間で企画したイベントを取得する
     */
    public function getEventPlanningFinish()
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
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('event.user_id', '=', \Auth::user()->id)
                ->whereRaw('event.end_at < NOW()')
                ->get();

        return $result;
    }

    /**
     * イベント情報を取得
     */
    public function getEventInfo($id)
    {
        $result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('evaluation_criteria.criteria_name as criteria_name'),
                        \DB::raw('user_images.image_data as user_image_data'),
                        \DB::raw('users.name as user_name'),
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
                ->LeftJoin('images as user_images', 'users.image_id', '=', 'user_images.id')
                ->where('event.id', '=', $id)
                ->get()
                ->first();

        return $result;
    }

    /**
     * イベント情報を削除
     */
    public function deleteEvent($id)
    {
        $event = $eventModel->find($id);
        $images = $imagesModel->find($event->image_id);
        $images->delete();
        $event->delete();
    }
}