@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-management', ['id' => Auth::user()->id]) }}">＜戻る</a>
    </div>
    <div id="container">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('event-search') }}" class="btn btn-primary" style="padding:0px 5px 0px 5px !important"><span style="font-size:13px">参加者一覧</span></a>
            </div>
            <div class="col-6">
                @if ($admin_flg)
                    <a href="{{ route('event-entry-admin', ['id' => $event_info->id]) }}" class="btn btn-primary" style="padding:0px 5px 0px 5px !important"><span style="font-size:13px">管理画面</span></a>
                @else
                    <a href="{{ route('event-entry', ['id' => $event_info->id]) }}" class="btn btn-primary" style="padding:0px 5px 0px 5px !important">
                        @if ($event_info->event_status == 2)
                            <span style="font-size:13px">結果</span>
                        @else
                            @if ($entry_status->entry_status == 1)
                                <span style="font-size:13px">参加中</span>
                            @else
                                <span style="font-size:13px">エントリー</span>
                            @endif
                        @endif
                    </a>
                @endif
            </div>
        </div>
        <div>
            <span style="font-size:11px;">{{print_r(Carbon\Carbon::parse($event_info->start_at)->format('Y/m/d'), true)}}</span>
        </div>
        <div>
            <span style="font-size:20px;">{{print_r($event_info->event_name, true)}}</span>
        </div>
        <div class="text-center">
            @php
                $src = "data:" . $event_info->imginfo . ";base64," . $event_info->enc_img;
            @endphp
            <a href="{{print_r($src, true)}}" target="_blank">
                @if (!empty($event_info->enc_img) and !empty($event_info->imginfo))
                    <img class="round-frame-info" src="{{print_r($src, true)}}" width="192" height="130">
                @endif
            </a>
        </div>
        <div class="mt-3">
            <div>
                <label>★魚種</label>
            </div>
            <div class="p-2 view-cont-info">
                <span>🐟&nbsp;&nbsp;{{print_r($event_info->fish_name, true)}}</span>
            </div>
            <div class="my-1 ml-1">
                <span class="font-size-11 font-color-red">イベントで測定対象の魚種です。<br>出世魚の場合成長途中(ブリならヤズなど)の魚種も含みます。</span>
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
                <span>{{print_r($event_info->note, true)}}</span>
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
