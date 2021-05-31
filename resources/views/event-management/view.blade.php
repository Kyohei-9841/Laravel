@extends('layouts.app')

@section('content')
    <div id="container">
        <div>
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('event-search') }}" class="btn btn-primary" style="padding:0px 5px 0px 5px !important"><span style="font-size:13px">イベントを探す</span></a>
                </div>
                <div class="col-6">
                    <a href="{{ route('event-registration', ['id' => Auth::user()->id]) }}" class="btn btn-primary" style="padding:0px 5px 0px 5px !important"><span style="font-size:13px">イベント登録</span></a>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs">
                <li class="nav-item" style="width:50%">
                  <a class="nav-link active" data-toggle="tab" href="#participation" style="text-align: center;">参加中イベント</a>
                </li>
                <li class="nav-item" style="width:50%">
                  <a class="nav-link" data-toggle="tab" href="#planning" style="text-align: center;">企画イベント</a>
                </li>
            </ul>
            <div class="tab-content" style="border: 1px solid #ebe5e5;">
                <div class="tab-pane active" id="participation">
                    @if (count($event_all_results) > 0)
                        @foreach ($event_all_results as $item)
                            <div class="div-border-event">
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="ml-1 background-color-lightgreen round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="point-leader">
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center" rowspan="4" style="padding:0px 30px 0px 5px">
                                            @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                @php
                                                    $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                                @endphp
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">
                                                    <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="border-none font-size-14">
                                            @if (!empty($item->user_enc_img) and !empty($item->user_imginfo))
                                                @php
                                                    $src = "data:" . $item->user_imginfo . ";base64," . $item->user_enc_img;
                                                @endphp
                                                <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                            @else
                                                <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                            @endif
                                            <a href="{{ route('profile', [
                                                'id' => $item->user_id // ユーザーID
                                                , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                ]) }}">
                                                <span class="font-size-12">{{ $item->user_name }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">対象魚：{{print_r($item->fish_name, true)}}</td>
                                    </tr>
                                </table>
                                <div class="font-size-14 point-leader-line-specification-3">
                                    {!! nl2br(e($item->note)) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="my-4 text-center">
                            <span class="font-size-10">現在参加中のイベントはありません。</span>
                        </div>
                    @endif
                    <div class="my-4 text-center background-color-lightgreen">
                        <span class="font-size-13 font-weight-bold">過去１週間以内に終了したイベント達！</span>
                    </div>
                    @if (count($event_finish_all_results) > 0)
                        @foreach ($event_finish_all_results as $item)
                            <div class="div-border-event">
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="ml-1 background-color-lightslategray round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="point-leader">
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center" rowspan="4" style="padding:0px 30px 0px 5px">
                                            @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                @php
                                                    $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                                @endphp
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">
                                                    <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="border-none font-size-14">
                                            @if (!empty($item->user_enc_img) and !empty($item->user_imginfo))
                                                @php
                                                    $src = "data:" . $item->user_imginfo . ";base64," . $item->user_enc_img;
                                                @endphp
                                                <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                            @else
                                                <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                            @endif
                                            <a href="{{ route('profile', [
                                                'id' => $item->user_id // ユーザーID
                                                , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                ]) }}">
                                                <span class="font-size-12">{{ $item->user_name }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">対象魚：{{print_r($item->fish_name, true)}}</td>
                                    </tr>
                                </table>
                                <div class="font-size-14 point-leader-line-specification-3">
                                    {!! nl2br(e($item->note)) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="my-2 text-center">
                            <span class="font-size-10">過去１週間で終了したイベントはありません。</span>
                        </div>
                    @endif
                </div>
                <div class="tab-pane" id="planning">
                    @if (count($planning_event_results) > 0)
                        @foreach ($planning_event_results as $item)
                            <div class="div-border-event">
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="ml-1 background-color-lightgreen round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="point-leader">
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center" rowspan="4" style="padding:0px 30px 0px 5px">
                                            @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                @php
                                                    $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                                @endphp
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">
                                                    <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="border-none font-size-14">
                                            @if (!empty($item->user_enc_img) and !empty($item->user_imginfo))
                                                @php
                                                    $src = "data:" . $item->user_imginfo . ";base64," . $item->user_enc_img;
                                                @endphp
                                                <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                            @else
                                                <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                            @endif
                                            <a href="{{ route('profile', [
                                                'id' => $item->user_id // ユーザーID
                                                , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                ]) }}">
                                                <span class="font-size-12">{{ $item->user_name }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">対象魚：{{print_r($item->fish_name, true)}}</td>
                                    </tr>
                                </table>
                                <div class="font-size-14 point-leader-line-specification-3">
                                    {!! nl2br(e($item->note)) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="my-4 text-center">
                            <span class="font-size-10">現在企画中のイベントはありません。</span>
                        </div>
                    @endif
                    <div class="my-4 text-center background-color-lightgreen">
                        <span class="font-size-13 font-weight-bold">過去１週間以内に終了したイベント達！</span>
                    </div>
                    @if (count($planning_finish_event_results) > 0)
                        @foreach ($planning_finish_event_results as $item)
                            <div class="div-border-event">
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="ml-1 background-color-lightslategray round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td colspan="2">
                                            <div class="point-leader">
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center" rowspan="4" style="padding:0px 30px 0px 5px">
                                            @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                @php
                                                    $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                                @endphp
                                                <a href="{{ route('event-info', ['id' => $item->id]) }}">
                                                    <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="border-none font-size-14">
                                            @if (!empty($item->user_enc_img) and !empty($item->user_imginfo))
                                                @php
                                                    $src = "data:" . $item->user_imginfo . ";base64," . $item->user_enc_img;
                                                @endphp
                                                <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                            @else
                                                <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                            @endif
                                            <a href="{{ route('profile', [
                                                'id' => $item->user_id // ユーザーID
                                                , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                ]) }}">
                                                <span class="font-size-12">{{ $item->user_name }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none font-size-14">対象魚：{{print_r($item->fish_name, true)}}</td>
                                    </tr>
                                </table>
                                <div class="font-size-14 point-leader-line-specification-3">
                                    {!! nl2br(e($item->note)) !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="my-2 text-center">
                            <span class="font-size-10">過去１週間で終了したイベントはありません。</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection
