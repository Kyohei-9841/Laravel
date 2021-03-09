@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                            <input class="form-input" type="text" id="fish_species" name="fish_species" placeholder="魚種" autocomplete="no">
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
    </div>
</div>
@endsection