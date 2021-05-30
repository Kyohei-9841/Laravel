<?php

namespace App\Utils;

class Utility
{
    /**
     * DBからの画像を直接表示できるように加工する
     */
    public static function isDirectDisplayImages($data)
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

        if (!empty($data->user_image_data)) {
            $enc_img = base64_encode($data->user_image_data);
            $data->user_enc_img = $enc_img;
            $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
            $data->user_imginfo = $imginfo['mime'];
        }

        return $data;
    }

    /**
     * フォルダの有無判定
     */
    public static function isPresenceOrAbsenceOfFolder() {
        $dir = '../storage/app/public/upload/' . \Auth::user()->id;

        if (!file_exists($dir)) {
            mkdir($dir);
        } else {
            Utility::remove_directory($dir);
        }
    }

    /**
     * フォルダの中身を再起的に削除する
     */
    public static function remove_directory($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            // ファイルかディレクトリによって処理を分ける
            if (is_dir("$dir/$file")) {
                // ディレクトリなら再度同じ関数を呼び出す
                remove_directory("$dir/$file");
            } else {
                // ファイルなら削除
                unlink("$dir/$file");
            }
        }
    }

    /**
     * DBからの画像を保存して表示できるように加工する
     */
    public static function isProcessingImages($data)
    {
        if (empty($data)) {
            return;
        }
        if (!empty($data->image_data)) {
            $now_date = date("H_i_s");
    
            $base64_encode_data = base64_encode($data->image_data);
    
            $img_url = 'upload/' . \Auth::user()->id . '/' . $now_date . rand() . '.jpg';
    
            file_put_contents('../storage/app/public/' . $img_url, base64_decode($base64_encode_data));
    
            $data->img_url = $img_url;
        }

        return $data;
    }

    /**
     * DBからの画像を保存して表示できるように加工する
     */
    public static function isProcessingImagesArr($data)
    {
        if (empty($data)) {
            return;
        }

        $now_date = date("H_i_s");
    
        for ($i = 0; $i < count($data); $i++) {
            if (!empty($data[$i]->image_data)) {
                $base64_encode_data = base64_encode($data[$i]->image_data);

                $img_url = 'upload/' . \Auth::user()->id . '/' . $now_date . '_' . $i . '_' . rand() . '.jpg';
    
                file_put_contents('../storage/app/public/' . $img_url, base64_decode($base64_encode_data));
    
                $data[$i]->img_url = $img_url;
    
            }
        }

        return $data;
    }
}