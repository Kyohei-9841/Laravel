<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Repositories\ChatsRepositoryInterface;
use App\Repositories\EntryListRepositoryInterface;
use App\Events\PusherEvent;
use App\User;

class ChatController extends Controller
{

    protected ChatsRepositoryInterface $chatsRepository;
    protected EntryListRepositoryInterface $entryListRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ChatsRepositoryInterface $chatsRepository, EntryListRepositoryInterface $entryListRepository)
    {
        $this->chatsRepository = $chatsRepository;
        $this->entryListRepository = $entryListRepository;
    }

    /**
     * チャット画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Utility::isPresenceOrAbsenceOfFolder();

        $eventId = $request->input('eventId');
        $hostUserId = $request->input('hostUserId');

        \Log::debug(print_r($eventId, true));
        \Log::debug(print_r($hostUserId, true));
        \Log::debug(print_r("ここは入っているか？", true));

        $chats = $this->chatsRepository->getChats($eventId);

        $entryList = $this->entryListRepository->getEntryList($eventId);

        Utility::isProcessingImagesArrChat($entryList);

        \Log::debug(print_r("チャットデータ", true));
        \Log::debug(print_r($chats, true));

        return view("chat.view")->with(compact('eventId', 'hostUserId', 'chats'));
    }

    /**
     * チャット送信
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        \Log::debug(print_r("ここは入っているか？", true));

        $hostUserId = $request->input('hostUserId');
        $message = $request->input('message');
        $eventId = $request->input('eventId');
        $imageId = $request->input('imageId');

        $userModel = new User;
        $sendUserName = $userModel->find(\Auth::user()->id)->name;
        $userImageId = $userModel->find(\Auth::user()->id)->image_id;

        \Log::debug(print_r($userModel->find(\Auth::user()->id), true));
        \Log::debug(print_r($userModel->find(\Auth::user()->id)->name, true));

        $params = array(
            'sendUserId' => \Auth::user()->id,
            'receiveUserId' => null,
            'message' => $message,
            'eventId' => $eventId,
            'imageId' => empty($imageId) ? null : $imageId,
            'individualFlg' => 0,
            'sendUserName' => $sendUserName,
            'receiveUserName' => null,
            'userImageId' => $userImageId
        );

        $chatsModel = $this->chatsRepository->sendChats($params);

        event(new PusherEvent($chatsModel));

        return response()->json(['message' => '投稿しました。']);
    }

}
