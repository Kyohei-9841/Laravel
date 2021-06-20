<?php

namespace App\Repositories;

interface FishingResultsRepositoryInterface
{
    /**
     * ユーザーの釣果をイベント単位で検索する
     */
    public function searchResultForEvent($id, $params);

    /**
     * 
     */
    public function updateResultMeaningfulFlg($id, $params);

}