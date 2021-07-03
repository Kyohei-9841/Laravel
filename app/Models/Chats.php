<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'chats';

    // 更新可能カラム
    protected $fillable = ['send_user_id', 'receive_user_id', 'message', 'event_id', 'image_id', 'individual_flg', 'send_user_name', 'receive_user_name', 'user_image_id', 'created_at', 'updated_at'];
}
