<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'evaluation_criteria';

    // 更新可能カラム
    protected $fillable = ['criteria_name'];
}
