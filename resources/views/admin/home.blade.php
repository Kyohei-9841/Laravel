@extends('layouts.app')

@section('content')
<div class="container">
    <div style="text-align:center;">
        <h1>管理者画面</h1>
    </div>
    <div>
        <a href="{{ route('approval') }}" class="login-button">画像承認</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="content">
                </div>
            </div>
        </div>
    </div>
    <div>
        <form action="{{ route('user-search') }}" method="post">
            @csrf
            <select id="userSelecter" name="userSelecter">
                <option value="0">全て</option>
                @foreach ($all_user as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $user_id ? "selected" : "" }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @foreach ($fishing_results as $item)
        @php
            $arr_file_dir = explode("/", $item->pic);
            $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
        @endphp
        <div>
            <table border="2" style="margin: 10px 0px">
                <tr>
                    <th>名前</th>
                    <td>{{print_r($item->name, true)}}</td>
                </tr>
                <tr>
                    <th>場所</th>
                    <td>{{print_r($item->position, true)}}</td>
                </tr>
                <tr>
                    <th>魚種</th>
                    <td>{{print_r($item->fish_species, true)}}</td>
                </tr>
                <tr>
                    <th>サイズ</th>
                    <td>{{print_r($item->size, true)}}</td>
                </tr>
                <tr>
                    <th>画像</th>
                    <td><img src="{{asset('storage/upload/' . $dir)}}" width="192" height="130"></td>
                </tr>
            </table>
        </div>
        <div>
            @if ($item->approval_status == 0)
                <span class="btn btn-danger">非承認</span>
            @else
                <span class="btn btn-success">承認</span>
            @endif
        </div>
    @endforeach
</div>
@endsection
