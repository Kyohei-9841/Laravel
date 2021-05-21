<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryList extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'entry_list';

    // 更新可能カラム
    protected $fillable = ['user_id', 'event_id', 'cancel_flg', 'cancel_date'];
}
