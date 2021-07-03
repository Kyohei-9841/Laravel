<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Utility;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\EntryListRepositoryInterface;

class EventInfoController extends Controller
{

    protected EventRepositoryInterface $eventRepository;
    protected EntryListRepositoryInterface $EntryListRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $eventRepository, EntryListRepositoryInterface $EntryListRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->EntryListRepository = $EntryListRepository;
    }

    /**
     * イベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        \Log::debug('イベント詳細');
        \Log::debug($id);

        Utility::isPresenceOrAbsenceOfFolder();

        $event_info = $this->eventRepository->getEventInfo($id);

        $event_info = Utility::isDirectDisplayImages($event_info);

        $admin_flg = false;

        if ($event_info->user_id == \Auth::user()->id) {
            $admin_flg = true;
        }

        $entry_status = $this->EntryListRepository->addEntryStatus($id);

        $entry_list = $this->EntryListRepository->getEntryList($id);

        if (count($entry_list) != 0) {
            foreach($entry_list as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        // $user_enc_img = base64_encode($event_info->user_image_data);
        // $event_info->user_enc_img = $user_enc_img;
        // $user_imginfo = getimagesize('data:application/octet-stream;base64,' . $user_enc_img);
        // $event_info->user_imginfo = $user_imginfo['mime'];

        return view("event-info.view")->with(compact('id', 'event_info', 'admin_flg', 'entry_status', 'entry_list'));
    }

    /**
     * 一般向けのイベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function viewGeneral(Request $request, $id)
    {        
        \Log::debug('イベント詳細');
        \Log::debug($id);

        $event_info = $this->eventRepository->getEventInfo($id);

        $event_info = Utility::isDirectDisplayImages($event_info);

        return view("event-info.general-page.view")->with(compact('event_info'));
    }

    public function delete(Request $request, $id)
    {
        $this->EntryListRepository->deleteEntryList($id);

        $this->eventRepository->deleteEvent($id);

        return redirect()->route('event-management', ['id' => \Auth::user()->id]);
    }
}
