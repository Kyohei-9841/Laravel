@extends('layouts.app')

@section('content')
    <div id="inner-header" class="text-center font-color-white">
        <div id="main-title">
            <h1>Fishingment</h1>
            <p>全国どこでも誰でも釣りイベント</p>
        </div>
        <div id="sub-title">
            <h2>Enjoy your fishing life.</h2>
        </div>
    </div>

    <div id="container">
        <h2>Fishingmentとは？</h2>
        <p class="ml-2">コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明コンテンツ説明</p>
        <h2>開催中のイベント</h2>
            @if (count($event_all) > 0)
                @foreach ($event_all as $item)
                    <hr>
                    <div class="ml-2">
                        <table style="width:100%">
                            <tr colspan="2">
                                <div class="my-1">
                                    <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                                </div>
                            </tr>
                            <tr>
                                <td rowspan="4" style="width:100px">
                                    @if (!empty($item->enc_img) and !empty($item->imginfo))
                                        @php
                                            $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                        @endphp
                                        <a href="{{print_r($src, true)}}" target="_blank">
                                            <img class="round-frame-top-event" src="{{print_r($src, true)}}" width="192" height="130">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="top-table-span">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d H:i'), true)}}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-size-11"><div class="top-table-span">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</div></td>
                            </tr>
                            <tr>
                                <td class="font-size-14"><div class="top-table-span">🐟&nbsp;&nbsp;{{print_r($item->fish_name, true)}}</div></td>
                            </tr>
                            <tr>
                                <td class="font-size-14"><div class="top-table-span">{{print_r($item->note, true)}}</div></td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="my-2 text-center">
                    <span class="font-size-10">まだイベントありません。</span>
                </div>
            @endif
        <h2>過去のイベント</h2>
        @if (count($event_finish) > 0)
            @foreach ($event_finish as $item)
                <hr>
                <div class="ml-2">
                    <table style="width:100%">
                        <tr colspan="2">
                            <div class="my-1">
                                <a href="{{ route('event-info', ['id' => $item->id]) }}">{{print_r($item->event_name, true)}}</a>
                            </div>
                        </tr>
                        <tr>
                            <td rowspan="4" style="width:100px">
                                @if (!empty($item->enc_img) and !empty($item->imginfo))
                                    @php
                                        $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                    @endphp
                                    <a href="{{print_r($src, true)}}" target="_blank">
                                        <img class="round-frame-top-event" src="{{print_r($src, true)}}" width="192" height="130">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="top-table-span">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d H:i'), true)}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-size-11"><div class="top-table-span">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;〜{{print_r(Carbon\Carbon::parse($item->end_at)->format('Y/m/d H:i'), true)}}</div></td>
                        </tr>
                        <tr>
                            <td class="font-size-14"><div class="top-table-span">🐟&nbsp;&nbsp;{{print_r($item->fish_name, true)}}</div></td>
                        </tr>
                        <tr>
                            <td class="font-size-14"><div class="top-table-span">{{print_r($item->note, true)}}</div></td>
                        </tr>
                    </table>
                </div>
            @endforeach
        @else
            <div class="my-2 text-center">
                <span class="font-size-10">まだイベントありません。</span>
            </div>
        @endif
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection
