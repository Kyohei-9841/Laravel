@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-management', ['id' => Auth::user()->id]) }}">＜戻る</a>
    </div>
    <div id="container">
        <div>
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
            data-target="#mdl-event-search">検索条件/並び替え設定</button>
            @include('event-search.modal-event-search')
        </div>
        <div>
            @if (count($event_all_results) == 0)
                <div class="my-4 text-center">
                    <p>
                        条件に合うイベントがありません。
                        <br>
                        <span style="font-size:12px;">※検索条件を変更して再検索をしてください。</span>
                    </p>
                </div>
            @else
                {{ $event_all_results->appends(request()->input())->links('pagination.pagination-custom') }}
                @foreach ($event_all_results as $item)
                    <div class="div-border-event">
                        <table class="border-none" style="margin: 10px 0px">
                            <tr class="border-none">
                                <td colspan="2">
                                    @if ($item->event_status == 2)
                                        <div class="ml-1 background-color-lightslategray round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
                                    @else
                                        <div class="ml-1 background-color-lightgreen round-frame-event-day text-center">{{print_r(Carbon\Carbon::parse($item->start_at)->format('Y/m/d'), true)}}</div>
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
                {{ $event_all_results->appends(request()->input())->links('pagination.pagination-custom') }}
            @endif
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
