<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishingResults extends Model
{
    // テーブルの紐付け(テーブル名がモデル名の複数形の場合は記述の必要なし)
    protected $table = 'fishing_results';

    // 更新可能カラム
    protected $fillable = [
        'user_id',
        'position',
        'fish_species',
        'size',
        'pic',
        'created_at',
        'updated_at',
        'approval_status',
        'event_id',
        'image_id',
        'latitude',
        'longitude',
        'amount',
        'weight',
        'meaningful_flg'];

    public function getUser(){
        return $this->hasOne('App\User');
    }

    public function getFishSpecies(){
        return $this->hasMany('App\Models\FishSpecies');
    }

    public function getEvent(){
        return $this->hasOne('App\Models\Event');
    }
}
