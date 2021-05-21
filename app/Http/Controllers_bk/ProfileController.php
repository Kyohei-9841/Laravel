<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{

    /**
     * プロフィール画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        \Log::debug('プロフィール');
        $user = User::find($id);
        return view("profile.view")->with(compact('user'));
    }
}
