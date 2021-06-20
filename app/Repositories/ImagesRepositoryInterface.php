<?php

namespace App\Repositories;

interface ImagesRepositoryInterface
{
    /**
     * 画像データを保存する
     */
    public function saveImage($id, $pic, $registration_flg);

    /**
     * 画像データを更新する
     */
    public function updateImage($params, $id);
}