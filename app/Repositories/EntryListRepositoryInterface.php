<?php

namespace App\Repositories;

interface EntryListRepositoryInterface
{
    /**
     * 開催中のイベントを取得
     */
    public function getEventHeld();

    /**
     * エントリーリストを登録する
     */
    public function addEntryList($params);
}