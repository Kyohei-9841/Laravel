<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FishingResults extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'fishing_results';

    // 更新可能カラム
    protected $fillable = ['user_id', 'position', 'fish_species', 'size', 'pic'];
}
