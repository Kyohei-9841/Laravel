<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\FishingResults;
use App\Images;

class ProfileController extends Controller
{

    /**
     * プロフィール画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $event_id = $request->input('event_id');
        $admin_flg = $request->input('admin_flg');
        $back_btn_flg = $request->input('back_btn_flg');

        $user = $this->get_user($id);

        if (!empty($user->image_data)) {
            $enc_img = base64_encode($user->image_data);
            $user->enc_img = $enc_img;
            $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
            $user->imginfo = $imginfo['mime'];
        }

        $fishing_results = $this->get_result_all($id);

        foreach($fishing_results as $result) {
            if (!empty($result->image_data)) {
                $enc_img = base64_encode($result->image_data);
                $result->enc_img = $enc_img;
                $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
                $result->imginfo = $imginfo['mime'];
            }
        }

        return view("profile.view")->with(compact('user', 'fishing_results', 'event_id', 'admin_flg', 'back_btn_flg'));
    }

    public function update(Request $request, $id)
    {

        $name = $request->input('name');
        $last_name = $request->input('last_name');
        $first_name = $request->input('first_name');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $prefectures = $request->input('prefectures');
        $address = $request->input('address');
        $profile = $request->input('profile');

        \Log::debug('アップロード：1');
        \Log::debug("name");
        \Log::debug($name);
        \Log::debug("last_name");
        \Log::debug($last_name);
        \Log::debug("first_name");
        \Log::debug($first_name);
        \Log::debug("age");
        \Log::debug($age);
        \Log::debug("gender");
        \Log::debug($gender);
        \Log::debug("prefectures");
        \Log::debug($prefectures);
        \Log::debug("address");
        \Log::debug($address);
        \Log::debug("profile");
        \Log::debug($profile);

        // $request->validate([
        //     'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        //     'event_name' => 'required|string|max:255',
        //     'start_at' => 'required|string|max:255',
        //     'end_at' => 'required|string|max:255',
        //     'entry_fee_flg' => 'required|string|max:255',
        //     'note' => 'required|string|max:255',
        //     'evaluation_criteria' => 'required|string|max:255',
        //     'fish_species' => 'required|string|max:255',
        // ]);

        \Log::debug('ここ通ってるか');

        $update_data = [
            'name' => $name,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'age' => $age,
            'gender' => $gender,
            'prefectures' => $prefectures,
            'address' => $address,
            'profile' => $profile,
        ];

        $user_model = new User();
        $user = $user_model->find($id);
        $user->update($update_data);

        return redirect()->route('profile', ['id' => $id]);
    }

    public function updateImage(Request $request)
    {

        $id = $request->input('id');
        $image_id = $request->input('image_id');

        \Log::debug('アップロード：1');
        \Log::debug("id");
        \Log::debug($id);
        \Log::debug("image_id");
        \Log::debug($image_id);

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        \Log::debug('ここ通ってるか');

        if (empty($image_id)) {
            $images = new Images();
            $images->user_id = $id;
            $images->registration_flg = 3;
            $images->image_data = file_get_contents($request->pic);
            $images->save();

            $image_id = $images->id;

            $update_data = [
                'image_id' => $image_id,
            ];
    
            $user_model = new User();
            $user = $user_model->find($id);
            $user->update($update_data);
    
        } else {
            $update_data = [
                'image_data' => file_get_contents($request->pic)
            ];
    
            $images_model = new Images();
            $images = $images_model->find($image_id);
            $images->update($update_data);
    
        }

        return redirect()->route('profile', ['id' => $id]);
    }

    /**
     * ユーザーの釣果を取得する
     */
    public function get_result_all(int $id)
    {
        $query_result = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('fishing_results.*')
                )
                ->join('images', function ($join) {
                    $join->on('fishing_results.image_id', '=', 'images.id')
                         ->where('images.registration_flg', '=', 2);
                })

                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->where('fishing_results.user_id', '=', $id)
                ->get();

        return $query_result;
    }

    /**
     * ユーザーを取得する
     */
    public function get_user(int $id)
    {
        $query_result = \DB::table('users')
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

        return $query_result;
    }
}
