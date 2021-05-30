@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url('/') }}">＜戻る</a>
    </div>
    <div id="container">
        <div class="mb-2">
            @if (!empty($event_info->user_enc_img) and !empty($event_info->user_imginfo))
                @php
                    $src = "data:" . $event_info->user_imginfo . ";base64," . $event_info->user_enc_img;
                @endphp
                <img class="round-frame-user-image" src="{{print_r($src, true)}}" width="192" height="130">
            @else
                <img class="round-frame-user-image" src="{{ asset('images/images_4.png')}}">
            @endif
            <span class="font-size-12">{{ $event_info->user_name }}</span>
        </div>    
        <div class="row">
            <div class="col-6">
                <a href="{{ route('login') }}" class="btn btn-primary font-size-10">ログイン</a>
            </div>
            <div class="col-6">
                <a href="{{ route('register') }}" class="btn btn-primary font-size-10">会員登録</a>
            </div>
        </div>
        <div>
            <span style="font-size:11px;">{{print_r(Carbon\Carbon::parse($event_info->start_at)->format('Y/m/d'), true)}}</span>
        </div>
        <div>
            <span style="font-size:20px;">{{print_r($event_info->event_name, true)}}</span>
        </div>
        <div class="text-center">
            @if (!empty($event_info->enc_img) and !empty($event_info->imginfo))
                @php
                    $src = "data:" . $event_info->imginfo . ";base64," . $event_info->enc_img;
                @endphp
                    <img class="round-frame-info" src="{{print_r($src, true)}}" width="192" height="130">
            @endif
        </div>
        <div class="mt-3">
            <div>
                <label>★対象魚</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>🐟&nbsp;&nbsp;{{print_r($event_info->fish_name, true)}}</span>
            </div>
            <div class="my-1 ml-1">
                <span class="font-size-11 font-color-red">イベントで測定対象の対象魚です。<br>出世魚の場合成長途中(ブリならヤズなど)の対象魚も含みます。</span>
            </div>

        </div>
        <div class="mt-3">
            <div>
                <label>★開始時刻</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>{{print_r(Carbon\Carbon::parse($event_info->start_at)->format('Y年m月d日　H時i分'), true)}}</span>
            </div>
            {{-- <div class="my-1">
                <span class="font-size-11">※注意事項注意事項注意事項注意事項</span>
            </div> --}}
        </div>
        <div class="mt-3">
            <div>
                <label>★終了時刻</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>{{print_r(Carbon\Carbon::parse($event_info->end_at)->format('Y年m月d日　H時i分'), true)}}</span>
            </div>
            {{-- <div class="my-1">
                <span class="font-size-11">※注意事項注意事項注意事項注意事項</span>
            </div> --}}
        </div>
        <div class="mt-3">
            <div>
                <label>★測定基準</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>{{print_r($event_info->criteria_name, true)}}</span>
            </div>
            <div class="my-1 ml-1">
                <span class="font-size-11 font-color-red">測定の方法です。<br>釣果をアップロードする際は測定基準にそった画像をアップロードしてください。</span>
            </div>
        </div>
        <div class="mt-3">
            <div>
                <label>★参加費</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>{{print_r($event_info->entry_fee_flg == 1 ? '無料' : '有料', true)}}</span>
            </div>
            {{-- <div class="my-1 ml-1">
                <span class="font-size-11 font-color-red">測定の方法です。<br>釣果をアップロードする際は測定基準にそった画像をアップロードしてください。</span>
            </div> --}}
        </div>
        <div class="mt-3">
            <div>
                <label>★イベント説明</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>{!! nl2br(e($event_info->note)) !!}</span>
            </div>
            {{-- <div class="my-1 ml-1">
                <span class="font-size-11 font-color-red">測定の方法です。<br>釣果をアップロードする際は測定基準にそった画像をアップロードしてください。</span>
            </div> --}}
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
