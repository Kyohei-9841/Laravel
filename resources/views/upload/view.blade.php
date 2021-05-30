@extends('layouts.app')

@section('content')
    <div id="container">

        <div class="mb-4">
            @php
                $measurement_name = "";
                if ($measurement == 1) {
                    $measurement_name = "サイズ";
                } else if ($measurement == 2) {
                    $measurement_name = "匹数";
                } else if ($measurement == 3) {
                    $measurement_name = "重さ";
                }
            @endphp
            <form id="uplord-form" autocomplete="off">
                <div id="focus"></div>
                <input hidden class="form-input" type="text" id="id" name="id" value='{{ Auth::user()->id }}'>
                <input hidden class="form-input" type="text" id="event-id" name="event-id" value='{{ $event_id }}'>
                <input hidden class="form-input" type="text" id="measurement" name="measurement" value='{{ $measurement }}'>
                <div class="row">
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
                            <label>★{{ $measurement_name }}</label>
                        </div>
                        <div>
                            <span class="font-size-11">※アップロードした画像と同じサイズを詳細に記載してください。</span>
                        </div>
                        <div>
                            <input class="form-input" type="text" id="measurement_result" name="measurement_result" placeholder="{{ $measurement_name }}" autocomplete="no" style="width:100%;">
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>測定基準</label>
                        </div>
                        <div>
                            <span class="font-size-11">※測定する際の基準単位を選択してください</span>
                        </div>
                        <div>
                            <select id="evaluation-criteria" name="evaluation-criteria" placeholder="測定基準" autocomplete="no">
                                @foreach($evaluation_criteria_result as $evaluation_criteria_data)
                                    <option value="{{ $evaluation_criteria_data->id }}">{{$evaluation_criteria_data->criteria_name}}</option>
                                @endforeach
                            </select>    
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>対象魚</label>
                        </div>
                        <div>
                            <span class="font-size-11">※対象対象魚を選択してください</span>
                        </div>
                        <div>
                            <select id="fish-species" name="fish-species" placeholder="対象魚" autocomplete="no">
                                @foreach($fish_species_result as $fish_species_data)
                                    <option value="{{ $fish_species_data->id }}">{{$fish_species_data->fish_name}}</option>
                                @endforeach
                            </select>    
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>参加費</label>
                        </div>
                        <div>
                            <span class="font-size-11">※参加費の有無を選択してください</span>
                        </div>
                        <div>
                            <select id="entry-fee-flg" name="entry-fee-flg" placeholder="参加費" autocomplete="no" disabled>
                                <option value="1" selected>無料</option>
                                <option value="2">有料</option>
                            </select>    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-3">
                        <div>
                            <label>イベント説明</label>
                        </div>
                        <div>
                            <span class="font-size-11">※イベントの詳細を記載してください</span>
                        </div>
                        <div>
                            <textarea class="form-input" id="note" name="note" placeholder="説明" autocomplete="no"></textarea>
                        </div>
                    </div>    
                </div> --}}
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






        {{-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('アップロード') }}</div>
                    <div class="card-body">
                        <form id="uplord-form" autocomplete="off">
                            <div id="focus"></div>
                            <input hidden class="form-input" type="text" id="id" name="id" value='{{ $id }}'>
                            <div class="upload-form-item">
                                <input class="form-input" type="text" id="position" name="position" placeholder="場所" autocomplete="no">
                            </div>
                            <div class="upload-form-item">
                                <input class="form-input" type="text" id="fish_species" name="fish_species" placeholder="対象魚" autocomplete="no">
                            </div>
                            <div class="upload-form-item">
                                <input class="form-input" type="text" id="size" name="size" placeholder="サイズ" autocomplete="no">
                            </div>
                            <div class="upload-form-item">
                                <canvas id="canvas" width="0" height="0" style="display: none;"></canvas>
                                <div id="images-disp"></div>
                            </div>
                            <div class="upload-form-item">
                                <label class="form-label" for="pic">アップロードする画像を選択してください</label>
                                <input class="form-input" type="file" id="pic" name="pic" accept="image/*" capture="environment">
                            </div>
                            <input id="form-submit" type="button" value="アップロード">
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!--/#container-->

    <footer>
        <small>Copyright&copy; <a href="index.html">SAMPLE WEB SITE</a> All Rights Reserved.</small>
        <span class="pr"><a href="http://template-party.com/" target="_blank">《Web Design:Template-Party》</a></span>
    </footer>

    <!--ページの上部に戻る「↑」ボタン-->
    <p class="nav-fix-pos-pagetop"><a href="#">↑</a></p>
@endsection