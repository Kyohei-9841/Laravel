@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-info', ['id' => $id]) }}">＜戻る</a>
    </div>
    <div id="container">
        <div class="text-center mb-2">
            <a class="btn btn-primary" href="{{route('approval', ['id' => $id])}}">{{ __('画像承認') }}</a>
        </div>
        <div>
            @if (count($ranking) > 0)
                @foreach ($ranking as $item)
                    <div class="div-border mx-3">
                        <table class="border-none" style="margin: 10px 0px">
                            <tr class="border-none">
                                <td class="border-none" colspan="2" style="padding:5px 10px 10px 10px">
                                    <span>{{ $item->rank }}位</span>
                                </td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                    @if (!empty($item->imginfo) && !empty($item->enc_img))
                                        @php
                                            $src = "data:" . $item->imginfo . ";base64," . $item->enc_img;
                                        @endphp
                                        <a href="{{print_r($src, true)}}" target="_blank">
                                                <img class="round-frame-rank" src="{{print_r($src, true)}}">
                                        </a>
                                    @else
                                        <img class="round-frame-rank" src="{{ asset('images/images_4.png')}}">
                                    @endif
                                </td>
                                <td class="border-none text-center">
                                    @if ($item->user_id == Auth::user()->id)
                                        <a href="{{ route('profile', [
                                            'id' => $item->user_id // ユーザーID
                                            , 'event_id' => $id // イベントID
                                            , 'admin_flg' => 1 // イベント作成者かのフラグ(プロフィール画面の戻るボタンに使用) 0:一般 1:管理者
                                            , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                            ]) }}">
                                            <span>{{ $item->user_name }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('profile', [
                                            'id' => $item->user_id // ユーザーID
                                            , 'event_id' => $id // イベントID
                                            , 'admin_flg' => 1 // イベント作成者かのフラグ(プロフィール画面の戻るボタンに使用) 0:一般 1:管理者
                                            , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                            ]) }}">
                                            <span>{{ $item->user_name }}</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none text-center">{{ $item->size }}cm</td>
                            </tr>
                            <tr class="border-none">
                                <td class="border-none text-center"></td>
                            </tr>
                        </table>
                        {{-- <div class="text-right">
                            <a href="{{route('delete', ['id' => $item->id])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">削除</a>
                        </div> --}}
                    </div>
                @endforeach
            @else
                <div class="text-center my-4">
                    <span class="font-size-10">まだ釣果が上がっておりません</span>
                </div>
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
