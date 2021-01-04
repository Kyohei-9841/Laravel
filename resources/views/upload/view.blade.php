@extends('layouts.app')

@section('content')
    <div style="text-align:center;">
        <h1>釣果アップロード</h1>
    </div>
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
                <label class="form-label" for="pic">画像</label>
                <input class="form-input" type="file" id="pic" name="pic">
            </div>
            <div class="upload-form-submit">
                <input type="submit" value="アップロード">
            </div>
        </form>
    </div>
@endsection