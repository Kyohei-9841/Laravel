@extends('layouts.app')

@section('content')
    <div style="text-align:center;">
        <h1>アップロード画像承認</h1>
    </div>
    <div>
        <form action="{{ route('approval-search') }}" method="post">
            @csrf
            <select id="approvalSelecter" name="approvalSelecter">
                <option value="0">全て</option>
                @foreach ($all_user as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $user_id ? "selected" : "" }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div style="text-align: center;">
        <div style="display: inline-block;">
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
                            <td><img src="{{asset('storage/upload/' . $dir)}}" width="800" height="500"></td>
                        </tr>
                    </table>
                </div>
                <a href="{{route('approval-update', ['id' => $item->id])}}" class="btn btn-success">承認する</a>
            @endforeach
        </div>
    </div>
@endsection