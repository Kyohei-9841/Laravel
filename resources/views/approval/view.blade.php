@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="text-left">
                                {{ __('アップロード承認') }}
                            </div>
                            <div class="text-right">
                                {{-- <button id="change_button" class="btn btn-success">切り替え</button> --}}
                                <div class="toggle-switch">
                                    <input id="change_button" class="toggle-input" type='checkbox' />
                                    <label for="toggle" class="toggle-label" />
                                    <span></span>
                                  </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                    <div class="unapproved-table">
                        @foreach ($unapproved_fishing_results as $item)
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
                            <a href="{{route('approval-update', ['id' => $item->id])}}" class="btn btn-success">承認する</a>
                        @endforeach
                    </div>
                    <div class="approved-table">
                        @foreach ($approved_fishing_results as $item)
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
                            <a href="{{route('approval-delete', ['id' => $item->id])}}" class="btn btn-success">承認取り消し</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection