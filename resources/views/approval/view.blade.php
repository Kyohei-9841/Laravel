@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-entry-admin', ['id' => $id]) }}">＜戻る</a>
    </div>
    <div id="container">
        <div class="font-size-15">
            <span>対象魚：[{{ $event->fish_name }}]</span>
        </div>
        <div>
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
            data-target="#mdl-fishing-results-search">検索条件/並び替え設定</button>
            @include('approval.modal-fishing-results-search')
        </div>
        @if (count($fishing_results) > 0)
            @foreach ($fishing_results as $item)
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
                                $measurement = "";
                                if ($item->measurement == 1) {
                                    $measurement = "cm";
                                } else if ($item->measurement == 2) {
                                    $measurement = "匹";
                                } else if ($item->measurement == 3) {
                                    $measurement = "Kg";
                                }
                            @endphp
                            <td class="border-none" colspan="2" style="padding:5px 10px 10px 10px">
                                <span class="{{ $style }} round-approval-table font-color-white">{{ print_r($approval, true) }}</span>
                                <span class="ml-5">{{ print_r($item->user_name, true) }}</span>
                            </td>
                        </tr>
                        <tr class="border-none">
                            <td class="border-none text-center" rowspan="3" style="padding:0px 30px 0px 5px">
                                @if (!empty($item->img_url))
                                    <a href="{{ asset('storage/' . $item->img_url)}}" target="_blank">
                                        <img class="round-frame" src="{{ asset('storage/' . $item->img_url)}}" width="192" height="130">
                                    </a>
                                @endif
                            </td>
                            <td class="border-none text-center">{{print_r(Carbon\Carbon::parse($item->created_at)->format('Y年m月d日'), true)}}</td>
                        </tr>
                        <tr class="border-none">
                            <td class="border-none text-center">{{print_r(Carbon\Carbon::parse($item->created_at)->format('H:i'), true)}}</td>
                        </tr>
                        <tr class="border-none">
                            <td class="border-none text-center">{{print_r($item->measurement_result, true)}}{{ $measurement }}</td>
                        </tr>
                    </table>
                    <div class="text-right mb-2">
                        {{-- イベント終了時には承認操作不可 --}}
                        @if ($event->event_status == 1)
                            {{-- 承認のボタン表示 --}}
                            @if ($item->approval_status == 1)
                                @if ($item->meaningful_flg == 1)
                                    <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 1])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">意義取消</a>
                                @endif
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 0])}}" class="btn btn-warning mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">承認取消</a>
                            {{-- 非承認のボタン表示 --}}
                            @elseIf ($item->approval_status == 2)
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 0])}}" class="btn btn-warning mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">未承認状態へ</a>
                            {{-- 未承認のボタン表示 --}}
                            @else
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 2])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">非承認</a>
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 1])}}" class="btn btn-primary mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">承認</a>
                            @endif
                        {{-- イベント終了後でも未承認は操作可能 --}}
                        @else
                            {{-- 未承認のボタン表示 --}}
                            @if ($item->approval_status == 0)
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 2])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">非承認</a>
                                <a href="{{route('approval-update', ['id' => $id, 'result_id' => $item->id, 'update_flg' => 1])}}" class="btn btn-primary mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">承認</a>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center my-4">
                <span class="font-size-10">対象のデータが存在しませんでした。</span>
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
