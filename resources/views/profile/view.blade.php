@extends('layouts.app')

@section('content')
    @if ($back_btn_flg == 1)
        <a href="{{ url()->previous() }}">＜戻る</a>
    @endif
    <div id="container">
        <div class="xs-display-none">
            <div class="row">
                <div class="col-4">
                    {{-- 本人場合 --}}
                    @if ($user->id == Auth::user()->id)
                        @if (!empty($user->img_url))
                            <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                <img class="round-frame-profile" src="{{ asset('storage/' . $user->img_url)}}">
                            </button>
                        @else
                            <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                                <img class="round-frame-profile" src="{{ asset('images/images_4.png')}}">
                            </button>
                        @endif
                    @else
                        @if (!empty($user->img_url))
                            <a href="{{ asset('storage/' . $user->img_url)}}" target="_blank">
                                <img class="round-frame-profile" src="{{ asset('storage/' . $user->img_url)}}">
                            </a>
                        @else
                            <img class="round-frame-profile" src="{{ asset('images/images_4.png')}}">
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
                            <span style="font-size:17px">{!! nl2br(e($user->profile)) !!}</span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">参加中のイベント</span></a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">過去参加イベント</span></a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="sm-display-none md-display-none lg-display-none xl-display-none xxl-display-none">
            <div class="row">
                <div class="col-5">
                    {{-- 本人場合 --}}
                    @if ($user->id == Auth::user()->id)
                        @if (!empty($user->img_url))
                        <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                            <img class="round-frame-profile" src="{{ asset('storage/' . $user->img_url)}}">
                        </button>
                    @else
                        <button type="button" class="clear-decoration" data-toggle="modal" data-target="#mdl-profile-image">
                            <img class="round-frame-profile" src="{{ asset('images/images_4.png')}}">
                        </button>
                    @endif
                @else
                    @if (!empty($user->img_url))
                        <a href="{{ asset('storage/' . $user->img_url)}}" target="_blank">
                            <img class="round-frame-profile" src="{{ asset('storage/' . $user->img_url)}}">
                        </a>
                    @else
                        <img class="round-frame-profile" src="{{ asset('images/images_4.png')}}">
                    @endif
                @endif
                </div>
                <div class="col-7">
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
                    <span style="font-size:17px">{!! nl2br(e($user->profile)) !!}</span>
                </div>
                {{-- <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">参加中のイベント</span></a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('/') }}" style="padding:0px 5px 0px 5px"><span style="font-size:13px">過去参加イベント</span></a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="mt-4">
                <h2>{{ __('釣果一覧') }}</h2>
                <div>
                    <form method="post">
                        @method('POST')
                        @csrf
                        <input hidden class="form-input" type="text" id="pull_id" name="pull_id" value='{{ $user->id }}'>
                        <input hidden class="form-input" type="text" id="back_btn_flg" name="back_btn_flg" value='{{ $back_btn_flg }}'>
                        <select class="width-80p" id="selected_id" name="selected_id" placeholder="イベント" autocomplete="no">
                            <option value="0" {{ $params['selected_id'] == 0 ? 'selected' : '' }}>全釣果</option>
                            @foreach($event_list as $event_list_data)
                                <option value="{{ $event_list_data->id }}" {{ $params['selected_id'] == $event_list_data->id ? 'selected' : '' }}>{{$event_list_data->event_name}}</option>
                            @endforeach
                        </select>    
                    </form>
                </div>    
            @if (count($fishing_results) > 0)
                {{ $fishing_results->appends(request()->input())->links('pagination.pagination-custom') }}
                @foreach ($fishing_results as $item)
                    @php
                        $measurement = "";
                        if ($item->measurement == 1) {
                            $measurement = "cm";
                        } else if ($item->measurement == 2) {
                            $measurement = "匹";
                        } else if ($item->measurement == 3) {
                            $measurement = "Kg";
                        }
                    @endphp
                    <div class="div-border">
                        <table class="border-none" style="margin: 10px 0px">
                            <tr class="border-none">
                                <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                    @if (!empty($item->img_url))
                                        <a href="{{ asset('storage/' . $item->img_url)}}" target="_blank">
                                            <img class="round-frame-rank" src="{{ asset('storage/' . $item->img_url)}}">
                                        </a>
                                    @endif
                                </td>
                                <td class="border-none">
                                    <div class="point-leader-150">
                                        {{print_r($item->event_name, true)}}
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none">{{print_r(Carbon\Carbon::parse($item->created_at)->format('Y年m月d日'), true)}}</td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none">{{print_r($item->fish_name, true)}}&nbsp;&nbsp;<span class="font-size-14">{{print_r($item->measurement_result, true)}}</span>{{ $measurement }}</td>
                            </tr>
                            @if ($user->id != Auth::user()->id && $item->approval_status == 1)
                                <tr class="border-none">
                                    <td class="border-none text-right" colspan="2">
                                        @if ($item->meaningful_flg == 0)
                                            <a href="{{route('meaningful', ['id' => $item->id, 'user_id' => $user->id, 'back_btn_flg' => $back_btn_flg, 'selected_id' => $params['selected_id']])}}"
                                                class="background-color-lightcoral font-color-white round-frame-meaningful">
                                                <span class="font-size-10 mt-1 mb-3 mx-3">意義あーり✋</span>
                                            </a>
                                        @else
                                            <a href="{{route('meaningful-release', ['id' => $item->id, 'user_id' => $user->id, 'back_btn_flg' => $back_btn_flg, 'selected_id' => $params['selected_id']])}}"
                                                class="background-color-lightgreen font-color-white round-frame-meaningful">
                                                <span class="font-size-10 mt-1 mb-3 mx-3">意義解除✋</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endforeach
                {{ $fishing_results->appends(request()->input())->links('pagination.pagination-custom') }}
            @else
                <div class="my-4 text-center"><span>釣果は登録されておりません</span></div>
            @endif
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
