<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
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
        \Log::debug(print_r("プロフィール", true));

        \Log::debug(print_r(Auth::check(), true));

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Utility::isPresenceOrAbsenceOfFolder();

        $selected_id = $request->input('selected_id');
        $back_btn_flg = $request->input('back_btn_flg');
        \Log::debug(print_r("イベントID", true));
        \Log::debug(print_r($selected_id, true));
        \Log::debug(print_r($back_btn_flg, true));

        $user = $this->get_user($id);

        $user = Utility::isProcessingImages($user);

        $params = array(
            'selected_id'=> empty($selected_id) ? '0' : $selected_id,
        );

        $fishing_results = $this->get_result_all($id, $params);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
        }

        $event_list =  $this->get_event_all($id);

        return view("profile.view")->with(compact('user', 'fishing_results', 'back_btn_flg', 'params', 'event_list'));
    }

    public function update(Request $request, $id)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
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

    public function searchPull(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $selected_id = $request->input('selected_id');
        $back_btn_flg = $request->input('back_btn_flg');

        return redirect()->route('profile', ['id' => $id, 'selected_id' => $selected_id, 'back_btn_flg' => $back_btn_flg]);
    }

    public function updateImage(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }    

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
    public function get_result_all($id, $params)
    {
        $selected_id = $params['selected_id'];

        $query = \DB::table('fishing_results')
                ->select(
                        \DB::raw('images.image_data as image_data'),
                        \DB::raw('fish_species.fish_name as fish_name'),
                        \DB::raw('event.event_name as event_name'),
                        \DB::raw('event.measurement as measurement'),
                        \DB::raw('case
                        when event.measurement = 1 then fishing_results.size
                        when event.measurement = 2 then fishing_results.amount
                        when event.measurement = 3 then fishing_results.weight
                        end as measurement_result'),
                        \DB::raw('fishing_results.*')
                )
                ->join('images', function ($join) {
                    $join->on('fishing_results.image_id', '=', 'images.id')
                         ->where('images.registration_flg', '=', 2);
                })
                ->join('event', 'fishing_results.event_id', '=', 'event.id')
                ->join('fish_species', 'fishing_results.fish_species', '=', 'fish_species.id')
                ->where('fishing_results.user_id', '=', $id);

        if ($selected_id != 0) {
            $query->where('fishing_results.event_id', '=', $selected_id);
        }
        
        $query_result = $query->orderBy('fishing_results.size', 'desc')->paginate(5);

        return $query_result;
    }

    /**
     * ユーザーを取得する
     */
    public function get_user($id)
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

    /**
     * 参加してるイベントを取得する
     */
    public function get_event_all($id)
    {
        $query_result = \DB::table('event')
                ->select(
                        \DB::raw('event.*'),
                )
                ->join('entry_list', 'entry_list.event_id', '=', 'event.id')
                ->where('entry_list.user_id', '=', $id)
                ->get();

        return $query_result;
    }
}
