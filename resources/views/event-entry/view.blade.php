@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-info', ['id' => $id]) }}">＜戻る</a>
    </div>
    <div id="container">
        @if ($entry_flg)
            @php
                $measurement = "";
                if ($measurement_flg == 1) {
                    $measurement = "cm";
                } else if ($measurement_flg == 2) {
                    $measurement = "匹";
                } else if ($measurement_flg == 3) {
                    $measurement = "Kg";
                }
            @endphp
            <div class="view-entry-ranking mb-4 mr-4 ml-4 text-center">
                <div>
                    <span>現順位</span>
                </div>
                <div>
                    @if ($rank)
                        <span class="font-color-dodgerblue font-weight-bold font-size-25">{{ $rank }}位 ({{ $rank }}/{{ count($entry_list) }})</span>
                    @else
                        <span class="font-size-15">{{ count($entry_list) }}名エントリー中<br>釣果を投稿しよう</span>
                    @endif
                </div>
            </div>
            <div>
                <div>
                    <span>順位</span>
                </div>
                <div>
                    <span class="font-size-10 font-color-red">※イベントの企画者にアップロード画像が承認されると反映されます。</span>
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
                                                        <span>{{ $ranking[$count]->rank }}位</span>&nbsp;<span class="font-size-10">{{ $ranking[$count]->measurement_result }}{{ $measurement }}</span>
                                                    </div>
                                                    <a href="{{ route('profile', [
                                                        'id' => $ranking[$count]->user_id // ユーザーID
                                                        , 'selected_id' => $id // 釣果一覧のプルダウン用
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
                                                    <div>
                                                        <span class="font-size-10">{{ $ranking[$count]->user_name }}</span>
                                                    </div>
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
            <div>
                <div>
                    <span>あなたの釣果</span>
                </div>
                <div>
                    {{-- 開始前以外の時に表示 --}}
                    @if ($event_info->event_status == 1 || $event_info->event_status == 2)
                        {{-- アップロードボタンはイベント中のみ表示 --}}
                        @if ($event_info->event_status == 1)
                            <div class="text-center my-2">
                                <a class="btn btn-primary" href="{{ route('upload-top', ['id' => Auth::user()->id, 'event_id' => $id]) }}">{{ __('アップロード') }}</a>
                                <a class="btn btn-primary" href="{{ route('chat', ['hostUserId' => $event_info->user_id, 'eventId' => $id]) }}">{{ __('チャット') }}</a>
                            </div>
                        @endif
                        @if (count($fishing_results) > 0)
                            @foreach ($fishing_results as $item)
                                {{-- @php
                                    $arr_file_dir = explode("/", $item->pic);
                                    $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
                                @endphp --}}
                                <div class="div-border mx-3">
                                    <table class="border-none" style="margin: 10px 0px">
                                        <tr class="border-none">
                                            @php
                                                $style = "";
                                                $approval = "";
                                                if ($item->approval_status == 0) {
                                                    $style = "bg-secondary";
                                                    $approval = "未承認";
                                                } else if ($item->approval_status == 1) {
                                                    $style = "bg-success";
                                                    $approval = "承認済";
                                                } else if ($item->approval_status == 2) {
                                                    $style = "bg-danger";
                                                    $approval = "非承認";
                                                }
                                            @endphp
                                            <td class="border-none" colspan="2" style="padding:5px 10px 10px 10px">
                                                <span class="{{ $style }} round-approval-table font-color-white">{{ print_r($approval, true) }}</span>
                                            </td>
                                        </tr>            
                                        <tr class="border-none">
                                            <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                                @if (!empty($item->img_url))
                                                    <a href="{{ asset('storage/' . $item->img_url)}}" target="_blank">
                                                        <img class="round-frame-rank" src="{{ asset('storage/' . $item->img_url)}}">
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="border-none text-center">{{print_r(Carbon\Carbon::parse($item->created_at)->format('Y年m月d日'), true)}}</td>
                                        </tr>
                                        <tr class="border-none">
                                            <td class="border-none text-center">{{print_r($item->fish_name, true)}}&nbsp;&nbsp;{{print_r($item->measurement_result, true)}}{{ $measurement }}</td>
                                        </tr>
                                        <tr class="border-none">
                                            <td class="border-none text-center">
                                                <a href="{{route('event-result-delete', ['id' => $item->id, 'event_id' => $id])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">削除</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center my-4">
                                <span class="font-size-10">あなたの釣果はまだありません。<br>釣果をアップロードしてください</span>
                            </div>
                        @endif
                    
                    @else
                        <div class="text-center my-4">
                            <span class="font-size-10">イベントの開始時刻は{{ Carbon\Carbon::parse($event_info->start_at)->format('Y年m月d日　H時i分') }}です<br>イベントの開始をお待ちください</span>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div>
                {{-- <div>
                    <span style="font-size:20px;">{{print_r($event_info->event_name, true)}}</span>
                </div>         --}}
                <div class="text-center my-3">
                    <span>※このイベントへ参加する場合はエントリーしてください</span>
                </div>
                <div class="text-center m-4">
                    <a class="btn btn-primary p-3" href="{{ route('entry', ['id' => $id]) }}">エントリーする</a>
                </div>    
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
