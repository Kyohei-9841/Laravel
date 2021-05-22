<?php

namespace App\Utils;

class Utility
{
    /**
     * DBからの画像を表示できるように加工する
     */
    public static function isProcessingImages($data)
    {
        if (empty($data)) {
            return;
        }

        if (!empty($data->image_data)) {
            $enc_img = base64_encode($data->image_data);
            $data->enc_img = $enc_img;
            $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
            $data->imginfo = $imginfo['mime'];
        }

        return $data;
    }
}