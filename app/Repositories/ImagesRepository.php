<?php

namespace App\Repositories;

use App\Models\Images;

class ImagesRepository implements ImagesRepositoryInterface
{
    protected $imagesModel;

    /**
    * @param object $user
    */
    public function __construct(Images $imagesModel)
    {
        $this->imagesModel = $imagesModel;
    }

    /**
     * 画像データを保存する
     */
    public function saveImage($id, $pic, $registration_flg)
    {
        $images = new Images();
        $images->user_id = $id;
        $images->registration_flg = $registration_flg;
        $images->image_data = file_get_contents($pic);
        $images->save();

        return $images->id;
}

    /**
     * 画像データを更新する
     */
    public function updateImage($params, $image_id)
    {
        $images = $this->imagesModel->find($image_id);
        $images->update($params);
}
}