<?php

namespace App\Repositories;

use App\Models\EvaluationCriteria;

class EvaluationCriteriaRepository implements EvaluationCriteriaRepositoryInterface
{
    protected $evaluationCriteriaModel;

    /**
    * @param object $user
    */
    public function __construct(EvaluationCriteria $evaluationCriteriaModel)
    {
        $this->evaluationCriteriaModel = $evaluationCriteriaModel;
    }

    /**
     * 測定基準を取得
     */
    public function getEvaluationCriteriaAll()
    {
        return $this->evaluationCriteriaModel->get();
    }
}