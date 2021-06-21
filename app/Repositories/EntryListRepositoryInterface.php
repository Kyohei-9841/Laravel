<?php

namespace App\Repositories;

interface EntryListRepositoryInterface
{
    /**
     * エントリーリストを取得
     */
    public function getEntryList($id);

    /**
     * エントリーリストを登録する
     */
    public function addEntryList($params);

    /**
     * エントリーステータスを取得する
     */
    public function addEntryStatus($params);

    /**
     * エントリーを削除
     */
    public function deleteEntryList($id);

    /**
     * エントリーリストとエントリーされてるかを取得する
     */
    public function getEntryData($id);
}