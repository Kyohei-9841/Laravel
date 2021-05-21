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
                    @foreach ($event_all_results as $item)
                        <div class="div-border-event">
                            <table class="border-none" style="margin: 10px 0px">
                                <tr class="border-none">
                                    <td colspan="2">
                                        <div class="ml-1" style="width:79px; background-color:lawngreen;">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
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
                                    <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                        @php
                                            $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                        @endphp
                                        <a href="{{print_r($src, true)}}" target="_blank">
                                            @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                            @endif
                                        </a>
                                    </td>
                                    <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                                </tr>
                                <tr class="border-none">
                                    <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                                </tr>
                                <tr class="border-none">
                                    <td class="border-none font-size-14">魚種：{{print_r($item->fish_name, true)}}</td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane" id="planning">
                    @foreach ($planning_event_results as $item)
                    <div class="div-border-event">
                        <table class="border-none" style="margin: 10px 0px">
                            <tr class="border-none">
                                <td colspan="2">
                                    @if ($item->event_status == 2)
                                        <div class="ml-1" style="width:79px; background-color:grey;">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                    @else
                                        <div class="ml-1" style="width:79px; background-color:lawngreen;">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                    @endif
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
                                <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                    @php
                                        $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                    @endphp
                                    <a href="{{print_r($src, true)}}" target="_blank">
                                        @if (!empty($item->enc_img) and !empty($item->imginfo))
                                            <img class="round-frame-event" src="{{print_r($src, true)}}" width="192" height="130">
                                        @endif
                                    </a>
                                </td>
                                <td class="border-none font-size-14">開始時刻：{{print_r(Carbon\Carbon::parse($item->start_at)->format('H:i'), true)}}</td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none font-size-11">〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none font-size-14">魚種：{{print_r($item->fish_name, true)}}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
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
