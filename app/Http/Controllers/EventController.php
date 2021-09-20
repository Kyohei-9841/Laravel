<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EventRepositoryInterface;

class EventController extends Controller
{

    protected EventRepositoryInterface $EventRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepositoryInterface $EventRepository)
    {
        $this->EventRepository = $EventRepository;
    }

    /**
     * イベント登録画面表示
     * @return \Illuminate\Http\Response
     */
    public function getEventAll(Request $request)
    {        
        \Log::debug('イベント詳細');

        $event = $this->EventRepository->getEvent();

        \Log::debug('データ返却');
        \Log::debug($event);

        return response()->json($event);
    }
}
