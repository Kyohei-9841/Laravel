@extends('layouts.app')

@section('content')
    <a href="{{ url()->previous() }}">＜戻る</a>
    <div id="container">
        <div class="mb-4">
            @php
                $measurement_name = "";
                if ($event_data->measurement == 1) {
                    $measurement_name = "サイズ";
                } else if ($event_data->measurement == 2) {
                    $measurement_name = "匹数";
                } else if ($event_data->measurement == 3) {
                    $measurement_name = "重さ";
                }
            @endphp
            <form id="uplord-form" autocomplete="off">
                <div id="focus"></div>
                <input hidden class="form-input" type="text" id="id" name="id" value='{{ Auth::user()->id }}'>
                <input hidden class="form-input" type="text" id="measurement" name="measurement" value='{{ $event_data->measurement }}'>
                <input hidden class="form-input" type="text" id="admin-flg" name="admin-flg" value='1'>
                <input type="hidden" id="event-lists" data-name="{{ $event_list }}">
                <div class="row">
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>★イベント</label>
                        </div>
                        <div>
                            <span class="font-size-11">※対象イベントを選択してください</span>
                        </div>
                        <div>
                            <select id="event-id" name="event-id" placeholder="イベント" autocomplete="no" {{ !empty($event_id) ? 'disabled' : ''}} style="width:70%">
                                @foreach($event_list as $event)
                                    <option value="{{ $event->id }}" {{ !empty($event_id) && $event->id == $event_id ? 'selected' : '' }}>{{$event->event_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>★対象魚</label>
                        </div>
                        <div>
                            <span class="font-size-11">※対象対象魚を選択してください</span>
                        </div>
                        <div>
                            <select id="fish-species" name="fish-species" placeholder="対象魚" autocomplete="no" disabled>
                                @foreach($fish_species_data as $fish_species)
                                    <option value="{{ $fish_species->id }}" {{$fish_species->id == $event_data->fish_species ? 'selected' : ''}}>{{$fish_species->fish_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label id="measurement-label">★{{ $measurement_name }}</label>
                        </div>
                        <div>
                            <span class="font-size-11">※アップロードした画像と同じサイズを詳細に記載してください。</span>
                            <span class="font-size-11">※単位は入力せず、数値(半角数値)のみ入力してください。</span>
                        </div>
                        <div>
                            <input class="form-input" type="text" id="measurement_result" name="measurement_result" autocomplete="no" style="width:50%;">
                        </div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <div>
                            <label class="form-label" for="pic">★アップロードする画像を選択してください</label>
                            <input class="form-input" type="file" id="pic" name="pic" accept="image/*" capture="environment">
                        </div>
                        <div>
                            <span class="font-size-11 font-color-red">・端末に保存されている画像はアップロードできません。<br>・アップロードする際にはサイズと対象魚がはっきり判明できるよう撮影をお願いいたします。<br>・鮮明な画像でない場合画像が承認されない可能性がありますのでご注意ください。</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <canvas id="canvas" width="0" height="0" style="display: none;"></canvas>
                        <div id="images-disp"></div>
                    </div>
                </div>
                <input id="form-submit" class="btn btn-primary" type="button" value="アップロード">
            </form>
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