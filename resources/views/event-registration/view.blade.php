@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ route('event-management', ['id' => Auth::user()->id]) }}">＜戻る</a>
    </div>
    <div id="container">
        <div class="mb-4">
            <form id="uplord-form" autocomplete="off">
                <div id="focus"></div>
                <input hidden class="form-input" type="text" id="id" name="id" value='{{ Auth::user()->id }}'>
                <div class="row">
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>タイトル</label>
                        </div>
                        <div>
                            <span class="font-size-11">※イベントのタイトルを記載してください</span>
                        </div>
                        <div>
                            <input class="form-input" type="text" id="event-name" name="event-name" placeholder="タイトル" autocomplete="no" style="width:100%;">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>開始時刻</label>
                        </div>
                        <div>
                            <span class="font-size-11">※イベントの開始時刻を選択してください</span>
                        </div>
                        <div>
                            <input class="form-input" type="date" id="start-at" name="start-at" placeholder="開始日" autocomplete="no" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                            <input class="form-input" type="time" id="start-at-time" name="start-at-time" placeholder="開始時間" autocomplete="no" value="{{Carbon\Carbon::now()->format('03:00')}}">    
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 my-3">
                        <div>
                            <label>終了時刻</label>
                        </div>
                        <div>
                            <span class="font-size-11">※イベントの終了時刻を選択してください</span>
                        </div>
                        <div>
                            <input class="form-input" type="date" id="end-at" name="end-at" placeholder="終了日" autocomplete="no" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                            <input class="form-input" type="time" id="end-at-time" name="end-at-time" placeholder="終了時間" autocomplete="no" value="{{Carbon\Carbon::now()->format('20:00')}}">
                        </div>
                    </div>    
                </div>
                <div class="row">
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
                            <label>魚種</label>
                        </div>
                        <div>
                            <span class="font-size-11">※対象魚種を選択してください</span>
                        </div>
                        <div>
                            <select id="fish-species" name="fish-species" placeholder="魚種" autocomplete="no">
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
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <div>
                            <label class="form-label" for="pic">アップロードする画像を選択してください</label>
                            <input class="form-input" type="file" id="pic" name="pic" accept="image/*">
                        </div>
                        <div>
                            <span class="font-size-11">※イベントのイメージ画像を選択してください</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <canvas id="canvas" width="0" height="0" style="display: none;"></canvas>
                        <div id="images-disp"></div>
                    </div>
                </div>
                <input id="event-form-submit" class="btn btn-primary" type="button" value="アップロード">
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
