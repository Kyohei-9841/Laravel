<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utility;
use App\Repositories\EventRepositoryInterface;

class EventManagementController extends Controller
{

    protected EventRepositoryInterface $eventRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
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
        
        \Log::debug('イベント管理');
        
        Utility::isPresenceOrAbsenceOfFolder();

        $planning_event_results = $this->eventRepository->getEventPlanning();
        $event_all_results = $this->eventRepository->getEventEntry();
        $planning_finish_event_results = $this->eventRepository->getEventPlanningFinish();
        $event_finish_all_results = $this->eventRepository->getEventEntryFinish();


        if (count($planning_event_results) != 0) {
            foreach($planning_event_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_all_results) != 0) {
            foreach($event_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($planning_finish_event_results) != 0) {
            foreach($planning_finish_event_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_finish_all_results) != 0) {
            foreach($event_finish_all_results as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view("event-management.view")->with(compact('event_all_results', 'planning_event_results', 'planning_finish_event_results', 'event_finish_all_results'));
    }
}
