@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('アップロード') }}</div>
                <div class="card-body">
                    <div>
                        <form action="{{ route('upload-submit')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input hidden class="form-input" type="text" id="id" name="id" value='{{ $id }}'>
                            <div class="upload-form-item">
                                <label class="form-label" for="position">場所</label>
                                <input class="form-input" type="text" id="position" name="position">
                            </div>
                            <div class="upload-form-item">
                                <label class="form-label" for="fish_species">魚種</label>
                                <input class="form-input" type="text" id="fish_species" name="fish_species">
                            </div>
                            <div class="upload-form-item">
                                <label class="form-label" for="size">サイズ</label>
                                <input class="form-input" type="text" id="size" name="size">
                            </div>
                            <div class="upload-form-item">
                                <label class="form-label" for="pic">アップロードする画像を選択してください</label>
                                <input class="form-input" type="file" id="pic" name="pic">
                                {{-- <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#mdl-outsourcing-section">撮影</button> --}}
                                {{-- <input type="file" id="pic" accept="image/*"> --}}
                                {{-- <a href="twitter://timeline">TwitterAppのタイムラインを表示！</a><br>
                                <a href="comgooglemaps://">Google Mapsのアプリを開く</a> --}}
                            </div>
                            <div class="upload-form-submit">
                                <input class="btn btn-primary" type="submit" value="アップロード">
                            </div>
                        </form>
                        {{-- @include('upload.camera') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection