<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishSpecies extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'fish_species';

    // 更新可能カラム
    protected $fillable = ['fish_name'];
}
