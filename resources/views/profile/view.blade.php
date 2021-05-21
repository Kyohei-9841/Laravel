@extends('layouts.app')

@section('content')
    <div>
        @if ($back_btn_flg == 1)
            {{-- 管理者フラグ 0:一般 1:管理者 --}}
            @if ($admin_flg == 1)
                <a href="{{ route('event-entry-admin', ['id' => $event_id]) }}">＜戻る</a>
            @else
                <a href="{{ route('event-entry', ['id' => $event_id]) }}">＜戻る</a>
            @endif
        @endif
    </div>
    <div id="container">
        <div class="xs-display-none">
            <div class="row">
                <div class="col-4">
                    {{-- 本人場合 --}}
                    @if ($user->id == Auth::user()->id)
                        @if (!empty($user->imginfo) && !empty($user->enc_img))
                            @php
                                $src = "data:" . $user->imginfo . ";base64," . $user->enc_img;
                            @endphp
                                <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                    <img class="round-frame" src="{{print_r($src, true)}}">
                                </button>
                        @else
                            <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                <img class="round-frame" src="{{ asset('images/images_4.png')}}">
                            </button>
                        @endif
                    @else
                        @if (!empty($user->imginfo) && !empty($user->enc_img))
                            @php
                                $src = "data:" . $user->imginfo . ";base64," . $user->enc_img;
                            @endphp
                            <a href="{{print_r($src, true)}}" target="_blank">
                                <img class="round-frame" src="{{print_r($src, true)}}">
                            </a>
                        @else
                            <img class="round-frame" src="{{ asset('images/images_4.png')}}">
                        @endif
                    @endif
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <span style="font-size:20px">{{ $user->name }}</span>
                                </div>
                                {{-- 本人場合 --}}
                                @if ($user->id == Auth::user()->id)
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                        data-target="#mdl-profile">プロフィールを編集</button>
                                    </div>
                                @endIf
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <span style="font-size:15px">{{ config("const.pref.{$user->prefectures}") }}</span>
                        </div>
                        <div class="col-12">
                            <span style="font-size:17px">{{ $user->profile }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">参加中のイベント</span></a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">過去参加イベント</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sm-display-none md-display-none lg-display-none xl-display-none xxl-display-none">
            <div class="row">
                <div class="col-4">
                    {{-- 本人場合 --}}
                    @if ($user->id == Auth::user()->id)
                        @if (!empty($user->imginfo) && !empty($user->enc_img))
                            @php
                                $src = "data:" . $user->imginfo . ";base64," . $user->enc_img;
                            @endphp
                                <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                    <img class="round-frame" src="{{print_r($src, true)}}">
                                </button>
                        @else
                            <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                <img class="round-frame" src="{{ asset('images/images_4.png')}}">
                            </button>
                        @endif
                    @else
                        @if (!empty($user->imginfo) && !empty($user->enc_img))
                            @php
                                $src = "data:" . $user->imginfo . ";base64," . $user->enc_img;
                            @endphp
                            <a href="{{print_r($src, true)}}" target="_blank">
                                <img class="round-frame" src="{{print_r($src, true)}}">
                            </a>
                        @else
                            <img class="round-frame" src="{{ asset('images/images_4.png')}}">
                        @endif
                    @endif
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-12">
                            <span style="font-size:20px">{{$user->name}}</span>
                        </div>
                        <div class="col-12">
                            <span style="font-size:13px">{{ config("const.pref.{$user->prefectures}") }}</span>
                        </div>
                        {{-- 本人場合 --}}
                        @if ($user->id == Auth::user()->id)
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#mdl-profile" style="padding:0px 5px 0px 5px !important">
                                    <span style="font-size:13px">プロフィールを編集</span>
                                </button>
                            </div>
                        @endIf
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <span style="font-size:17px">{{ $user->profile }}</span>
                </div>
                <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">参加中のイベント</span></a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">過去参加イベント</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <div class="card">
                <div class="card-header">{{ __('釣果一覧') }}</div>
                <div class="card-body" style="padding:5px !important">
                    @if (count($fishing_results) > 0)
                        @foreach ($fishing_results as $item)
                            <div class="div-border">
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                            @php
                                                $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                            @endphp
                                            <a href="{{print_r($src, true)}}" target="_blank">
                                                @if (!empty($item->enc_img) and !empty($item->imginfo))
                                                    <img class="round-frame" src="{{print_r($src, true)}}" width="192" height="130">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="border-none text-center">{{print_r(Carbon\Carbon::parse($item->created_at)->format('Y年m月d日'), true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">{{print_r($item->fish_name, true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">{{print_r($item->size, true)}}cm</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div><p>あなたの釣果はまだありません。<br>イベントに参加し、釣果をアップロードしよう！</p></div>
                        <div>
                            <a href="{{route('event-search')}}"><p>{{ __('イベント検索') }}</p></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @include('profile.modal-profile')
        @include('profile.modal-profile-image')
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection
