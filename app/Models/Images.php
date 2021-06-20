<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'images';

    // 更新可能カラム
    protected $fillable = ['user_id', 'event_id', 'image_data'];
}
