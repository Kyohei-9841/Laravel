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
            <div>
                <span>順位</span>
            </div>
            <div>
                <span class="font-size-10 font-color-red">※アップロードされた画像を承認すると順位に反映されます。</span>
            </div>
            <div>
                @if (count($ranking) > 0)
                    <div class="mx-3">
                        <table class="border-none" style="margin: 10px auto">
                            @php
                                $number_of_loops = ceil(count($ranking)/3);
                                $count = 0;
                            @endphp
                            @for ($i = 0; $i < $number_of_loops; $i++)
                                <tr class="border-none">
                                    @for ($j = 1; $j <= 3; $j++)
                                        @if (!empty($ranking[$count]))
                                            <td class="border-none">
                                                <div class="point-leader-90">
                                                    <span>{{ $ranking[$count]->rank }}位</span>&nbsp;<span class="font-size-10">{{ $ranking[$count]->user_name }}</span>
                                                </div>
                                                <a href="{{ route('profile', [
                                                    'id' => $ranking[$count]->user_id // ユーザーID
                                                    , 'event_id' => $id // イベントID
                                                    , 'selected_id' => $id // 釣果一覧のプルダウン用
                                                    , 'admin_flg' => 1 // イベント作成者かのフラグ(プロフィール画面の戻るボタンに使用) 0:一般 1:管理者
                                                    , 'back_btn_flg' => 1 // 戻るボタンの表示フラグ
                                                    ]) }}">
                                                    @if (!empty($ranking[$count]->imginfo) && !empty($ranking[$count]->enc_img))
                                                        @php
                                                            $src = "data:" . $ranking[$count]->imginfo . ";base64," . $ranking[$count]->enc_img;
                                                        @endphp
                                                        <img class="round-frame-rank" src="{{print_r($src, true)}}">
                                                    @else
                                                        <img class="round-frame-rank" src="{{ asset('images/images_4.png')}}">
                                                    @endif
                                                </a>
                                            </td>
                                        @endif
                                        @php
                                            $count++;
                                        @endphp
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div>
                @else
                    <div class="text-center my-4">
                        <span class="font-size-10">まだ釣果が上がっておりません</span>
                    </div>
                @endif
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
