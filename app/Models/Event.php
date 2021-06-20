<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'event';

    // 更新可能カラム
    protected $fillable = ['user_id', 'event_name', 'start_at', 'end_at', 'measurement', 'entry_fee_flg', 'image_id', 'fish_species', 'note'];
}
