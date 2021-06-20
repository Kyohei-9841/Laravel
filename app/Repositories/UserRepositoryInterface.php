<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    /**
     * ユーザー情報を取得する
     */
    public function getUser($id);

    /**
     * ユーザー情報を更新する
     */
    public function updateUser($params, $id);

    /**
     * ユーザー画像IDを更新する
     */
    public function updateUserImageId($params, $id);
}