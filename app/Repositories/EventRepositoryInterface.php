<?php

namespace App\Repositories;

interface EventRepositoryInterface
{
    /**
     * 開催中のイベントを取得
     */
    public function getEventHeld();

    /**
     * 終わったイベントを取得
     */
    public function getEventFinish();

    /**
     * ユーザーが参加してるイベントを取得する
     */
    public function getEventAllUser($id);

    /**
     * イベントを検索する
     */
    public function searchEvent($params);

    /**
     * イベントを登録する
     */
    public function addEvent($params);

    /**
     * 参加中のイベントを取得する
     */
    public function getEventEntry();

    /**
     * 企画中のイベントを取得する
     */
    public function getEventPlanning();

    /**
     * 過去１週間で参加したイベントを取得する
     */
    public function getEventEntryFinish();

    /**
     * 過去１週間で企画したイベントを取得する
     */
    public function getEventPlanningFinish();

}