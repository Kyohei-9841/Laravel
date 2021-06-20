<?php

namespace App\Repositories;

interface EvaluationCriteriaRepositoryInterface
{
    /**
     * 開催中のイベントを取得
     */
    public function getEvaluationCriteriaAll();
}