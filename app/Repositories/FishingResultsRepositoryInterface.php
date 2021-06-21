<?php

namespace App\Repositories;

interface FishingResultsRepositoryInterface
{
    /**
     * ユーザーの釣果をイベント単位で検索する
     */
    public function searchResultForEvent($id, $params);

    /**
     * 意義フラグ更新
     */
    public function updateResultMeaningfulFlg($id, $params);

    /**
     * 釣果を検索する
     */
    public function searchFishingResults($params, $id);

    /**
     * 承認ステータスを更新
     */
    public function updateApprovalStatus($result_id, $update_flg);

    /**
     * 釣果結果を登録
     */
    public function addFishingResults($params, $measurement);

    /**
     * ユーザーの釣果情報を取得
     */
    public function getFishingResultsUser($id);

    /**
     * 釣果結果を削除
     */
    public function deleteFishingResults($id);

    /**
     * ランキングを取得
     */
    public function getRanking($id, $measurement);

}