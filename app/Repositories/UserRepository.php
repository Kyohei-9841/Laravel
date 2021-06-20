<?php

namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{
    protected $userModel;

    /**
    * @param object $user
    */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * ユーザー情報を取得する
     */
    public function getUser($id)
    {
        $result = \DB::table('users')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('images.id as image_id'),
                        \DB::raw('users.*')
                )
                ->leftJoin('images', function ($join) {
                    $join->on('users.image_id', '=', 'images.id')
                         ->where('images.registration_flg', '=', 3);
                })
                ->where('users.id', '=', $id)
                ->get()
                ->first();

        return $result;
    }

    /**
     * ユーザー情報を更新する
     */
    public function updateUser($params, $id)
    {
        $user = $this->userModel->find($id);
        $user->update($params);
    }

    /**
     * ユーザー情報を更新する
     */
    public function updateUserImageId($params, $id)
    {
        $user = $this->userModel->find($id);
        $user->update($params);
} 

}