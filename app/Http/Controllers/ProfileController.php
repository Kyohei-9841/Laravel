<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\FishingResultsRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ImagesRepositoryInterface;

class ProfileController extends Controller
{

    protected EventRepositoryInterface $eventRepository;
    protected FishingResultsRepositoryInterface $fishingResultsRepository;
    protected UserRepositoryInterface $userRepository;
    protected ImagesRepositoryInterface $imagesRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EventRepositoryInterface $eventRepository
        , FishingResultsRepositoryInterface $fishingResultsRepository
        , UserRepositoryInterface $userRepository
        , ImagesRepositoryInterface $imagesRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->fishingResultsRepository = $fishingResultsRepository;
        $this->userRepository = $userRepository;
        $this->imagesRepository = $imagesRepository;

    }

    /**
     * プロフィール画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Utility::isPresenceOrAbsenceOfFolder();

        $selected_id = $request->input('selected_id');
        $back_btn_flg = $request->input('back_btn_flg');

        $user = $this->userRepository->getUser($id);

        $user = Utility::isProcessingImages($user);

        $params = array(
            'selected_id'=> empty($selected_id) ? '0' : $selected_id,
        );

        $fishing_results = $this->fishingResultsRepository->searchResultForEvent($id, $params);

        if (count($fishing_results) != 0) {
            $fishing_results = Utility::isProcessingImagesArr($fishing_results);
        }

        $event_list = $this->eventRepository->getEventAllUser($id);

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

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
        ]);

        $params = [
            'name' => $name,
            'last_name' => $last_name,
            'first_name' => $first_name,
            'age' => $age,
            'gender' => $gender,
            'prefectures' => $prefectures,
            'address' => $address,
            'profile' => $profile,
        ];

        $this->userRepository->updateUser($params, $id);

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

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (empty($image_id)) {

            $image_id = $this->imagesRepository->saveImage($id, $request->pic, 3);

            $params = [
                'image_id' => $image_id,
            ];
    
            $this->userRepository->updateUserImageId($params, $id);
    
        } else {
            $params = [
                'image_data' => file_get_contents($request->pic)
            ];
    
            $this->imagesRepository->updateImage($params, $image_id);    
        }

        return redirect()->route('profile', ['id' => $id]);
    }

    public function meaningful(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = $request->input('user_id');
        $selected_id = $request->input('selected_id');
        $back_btn_flg = $request->input('back_btn_flg');

        $params = [
            'meaningful_flg' => 1,
        ];

        $this->fishingResultsRepository->updateResultMeaningfulFlg($id, $params);    

        return redirect()->route('profile', ['id' => $user_id, 'selected_id' => $selected_id, 'back_btn_flg' => $back_btn_flg]);
    }

    public function meaningfulRelease(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user_id = $request->input('user_id');
        $selected_id = $request->input('selected_id');
        $back_btn_flg = $request->input('back_btn_flg');

        $params = [
            'meaningful_flg' => 0,
        ];

        $this->fishingResultsRepository->updateResultMeaningfulFlg($id, $params);    

        return redirect()->route('profile', ['id' => $user_id, 'selected_id' => $selected_id, 'back_btn_flg' => $back_btn_flg]);
    }
}
