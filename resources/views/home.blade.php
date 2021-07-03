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
        <p class="ml-2">Fishingment(フィッシングメント)はオンラインでどこでも誰でも釣りのイベント(大会)を開催できるサービスです。
            <br>よくある釣り大会は特定の場所に会場が設けられ、範囲と時間が決まっている中でサイズや大きさを競い合うことが一般的です。
            <br>しかし、Fishingmentではオンラインでのイベント(大会)ですので、範囲や時間の縛りがありません。
            <br>例えば1年を通して大きなアオリイカを釣り上げた人の勝利など、普通のイベントではできないことが可能です。
            <br>そして、先ほどからイベント(大会)との表記をしているのは、もちろん誰が一番かを競い合う大会を開催するも良しですが、アジの数釣りイベントで「たくさん釣れたね〜」のようなラフなイベントもあっていいと思うからです。
            <br>本気の釣り大会やラフな釣りイベントなど参加者通しでメッセージをかわしながら楽しんでください。
            <br>また、釣りのイベント(大会)を開催したいみなさん！是非Fishingmentでイベント(大会)を開催していただき、釣りの楽しさを広げて参りましょう！
            <br>それでは良い釣りライフを！！！！
        </p>
        <h2>開催中のイベント</h2>
            @if (count($event_all) > 0)
                @for ($i = 0; $i < count($event_all) && $i < 3; $i++)
                    <hr>
                    <div class="ml-2">
                        <div class="my-1">
                            @if (Auth::check())
                                <a href="{{ route('event-info', ['id' => $event_all[$i]->id]) }}">{{print_r($event_all[$i]->event_name, true)}}</a>
                            @else
                                <a href="{{ route('event-info-general', ['id' => $event_all[$i]->id]) }}">{{print_r($event_all[$i]->event_name, true)}}</a>
                            @endif
                        </div>
                        <table style="width:100%">
                            <tr>
                                <td rowspan="4" style="width:100px">
                                    @if (!empty($event_all[$i]->enc_img) and !empty($event_all[$i]->imginfo))
                                        @php
                                            $src = "data:" . $event_all[$i]->imginfo . ";base64," . $event_all[$i]->enc_img;
                                        @endphp
                                        <a href="{{ route('event-info-general', ['id' => $event_all[$i]->id]) }}">
                                            <img class="round-frame-top-event" src="{{print_r($src, true)}}" width="192" height="130">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="top-table-span">
                                        @if (!empty($event_all[$i]->user_enc_img) and !empty($event_all[$i]->user_imginfo))
                                            @php
                                                $src = "data:" . $event_all[$i]->user_imginfo . ";base64," . $event_all[$i]->user_enc_img;
                                            @endphp
                                            <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                        @else
                                            <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                        @endif
                                        @if (Auth::check())
                                            <a href="{{ route('profile', [
                                                'id' => $event_all[$i]->user_id // ユーザーID
                                                , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                ]) }}">
                                                <span class="font-size-12">{{ $event_all[$i]->user_name }}</span>
                                            </a>
                                        @else
                                            <span class="font-size-12">{{ $event_all[$i]->user_name }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="top-table-span">{{print_r(Carbon\Carbon::parse($event_all[$i]->start_at)->format('Y/m/d H:i'), true)}}</div></td>
                            </tr>
                            <tr>
                                <td class="font-size-11"><div class="top-table-span">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;〜{{print_r(Carbon\Carbon::parse($event_all[$i]->end_at)->format('Y/m/d H:i'), true)}}</div></td>
                            </tr>
                            <tr>
                                <td class="font-size-14"><div class="top-table-span">🐟&nbsp;&nbsp;{{print_r($event_all[$i]->fish_name, true)}}</div></td>
                            </tr>
                        </table>
                        <div class="font-size-14 point-leader-line-specification-3">
                            {!! nl2br(e($event_all[$i]->note)) !!}
                        </div>
                    </div>
                @endfor
                <hr>
                @if (count($event_all) > 2)
                    <div class="my-2 text-right">
                        <a href="{{ route('event-search-submit') }}">もっと見る</a>
                    </div>    
                @endif
            @else
                <div class="my-2 text-center">
                    <span class="font-size-10">まだイベントありません。</span>
                </div>
            @endif
        <h2>過去のイベント</h2>
        @if (count($event_finish) > 0)
            @for ($j = 0; $j < count($event_finish) && $j < 3; $j++)
                <hr>
                <div class="ml-2">
                    <div class="my-1">
                        @if (Auth::check())
                            <a href="{{ route('event-info', ['id' => $event_finish[$j]->id]) }}">{{print_r($event_finish[$j]->event_name, true)}}</a>
                        @else
                            <a href="{{ route('event-info-general', ['id' => $event_finish[$j]->id]) }}">{{print_r($event_finish[$j]->event_name, true)}}</a>
                        @endif
                    </div>
                    <table style="width:100%">
                        <tr>
                            <td rowspan="4" style="width:100px">
                                @if (!empty($event_finish[$j]->enc_img) and !empty($event_finish[$j]->imginfo))
                                    @php
                                        $src = "data:" . $event_finish[$j]->imginfo . ";base64," . $event_finish[$j]->enc_img;
                                    @endphp
                                    <a href="{{ route('event-info-general', ['id' => $event_finish[$j]->id]) }}">
                                        <img class="round-frame-top-event" src="{{print_r($src, true)}}" width="192" height="130">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div class="top-table-span">
                                    @if (!empty($event_finish[$j]->user_enc_img) and !empty($event_finish[$j]->user_imginfo))
                                        @php
                                            $src = "data:" . $event_finish[$j]->user_imginfo . ";base64," . $event_finish[$j]->user_enc_img;
                                        @endphp
                                        <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
                                    @else
                                        <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
                                    @endif
                                    @if (Auth::check())
                                        <a href="{{ route('profile', [
                                            'id' => $event_finish[$j]->user_id // ユーザーID
                                            , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                            ]) }}">
                                            <span class="font-size-12">{{ $event_finish[$j]->user_name }}</span>
                                        </a>
                                    @else
                                        <span class="font-size-12">{{ $event_finish[$j]->user_name }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="top-table-span">{{print_r(Carbon\Carbon::parse($event_finish[$j]->start_at)->format('Y/m/d H:i'), true)}}</div></td>
                        </tr>

                        <tr>
                            <td class="font-size-11"><div class="top-table-span">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;〜{{print_r(Carbon\Carbon::parse($event_finish[$j]->end_at)->format('Y/m/d H:i'), true)}}</div></td>
                        </tr>
                        <tr>
                            <td class="font-size-14"><div class="top-table-span">🐟&nbsp;&nbsp;{{print_r($event_finish[$j]->fish_name, true)}}</div></td>
                        </tr>
                    </table>
                    <div class="font-size-14 point-leader-line-specification-3">
                        {!! nl2br(e($event_finish[$j]->note)) !!}
                    </div>
                </div>
            @endfor
            <hr>
            @if (count($event_finish) > 3)
                <div class="my-2 text-right">
                    もっと見る
                </div>    
            @endif
        @else
            <div class="my-2 text-center">
                <span class="font-size-10">まだイベントありません。</span>
            </div>
        @endif

        <h2>今後予定してる追加機能</h2>
        <li>
            <ul>イベントのプライベートモード</ul>
        </li>
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection
