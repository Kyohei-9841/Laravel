<?php

namespace App\Repositories;

interface ChatsRepositoryInterface
{
    /**
     * チャットの取得
     */
    public function getChats($eventId);

    /**
     * チャット送信
     */
    public function sendChats($params);
}