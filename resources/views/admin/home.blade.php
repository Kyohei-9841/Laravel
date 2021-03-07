@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('AdminPage') }}</div>
                <div class="card-body">
                    <div>
                        <a href="{{ route('approval') }}" class="login-button">画像承認</a>
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
                            <div><span>{{print_r($item->name, true)}}</span></div>
                            <table class="border-none" style="margin: 10px 0px">
                                <tr class="border-none">
                                    <td class="border-none" rowspan="3"><img class="round-frame" src="{{asset('storage/upload/' . $dir)}}" width="192" height="130"></td>
                                    <td class="border-none">場所：</td>
                                    <td class="border-none">{{print_r($item->position, true)}}</td>
                                </tr>
                                <tr class="border-none">
                                    <td class="border-none">魚種：</td>
                                    <td class="border-none">{{print_r($item->fish_species, true)}}</td>
                                </tr>
                                <tr class="border-none">
                                    <td class="border-none">サイズ：</td>
                                    <td class="border-none">{{print_r($item->size, true)}}</td>
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
            </div>
        </div>
    </div>
</div>
@endsection
