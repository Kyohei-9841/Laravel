<?php

namespace App\Http\Controllers;

use App\Utils\Utility;
use App\Repositories\EventRepositoryInterface;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $event_all = $this->eventRepository->getEventHeld();
        $event_finish = $this->eventRepository->getEventFinish();

        if (count($event_all) != 0) {
            foreach($event_all as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }
        if (count($event_finish) != 0) {
            foreach($event_finish as $result) {
                $result = Utility::isDirectDisplayImages($result);
            }
        }

        return view('home')->with(compact('event_all', 'event_finish'));
    }
}
