<?php

namespace App\Repositories;

use App\Models\Chats;

class ChatsRepository implements ChatsRepositoryInterface
{
    protected $chatsModel;

    /**
    * @param object $user
    */
    public function __construct(Chats $chatsModel)
    {
        $this->chatsModel = $chatsModel;
    }

    /**
     * チャットの取得
     */
    public function getChats($eventId)
    {
        $result = \DB::table('chats')
            ->select(
                    \DB::raw('chats.*'),
            )
            ->where('chats.event_id', '=', $eventId)
            ->get();

        return $result;

    }

    /**
     * チャット送信
     */
    public function sendChats($params)
    {
        $chatsModel = new Chats;
        $chatsModel->send_user_id = $params['sendUserId'];
        $chatsModel->receive_user_id = $params['receiveUserId'];
        $chatsModel->message = $params['message'];
        $chatsModel->event_id = $params['eventId'];
        $chatsModel->image_id = $params['imageId'];
        $chatsModel->individual_flg = $params['individualFlg'];
        $chatsModel->send_user_name = $params['sendUserName'];
        $chatsModel->receive_user_name = $params['receiveUserName'];
        $chatsModel->user_image_id = $params['userImageId'];
        $chatsModel->save();

        return $chatsModel;
    }
}