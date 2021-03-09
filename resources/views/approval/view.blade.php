@extends('layouts.app')

@section('content')
<footer class="fixed-bottom" style="background-color: transparent;">
	<div class="row">
		<div class="col-8"></div>
		<div class="col-3" align="left">
            {{-- <a href="{{route('approval')}}" class="btn btn-primary" style="box-shadow: 3px 3px 4px -2px black"><i class="now-ui-icons ui-2_like"></i></a> --}}
            <div class="toggle-switch">
                <input id="change_button" class="toggle-input" type='checkbox' />
                <label for="toggle" class="toggle-label" />
                <span></span>
            </div> 
        </div>
        <div class="col-1"></div>
	</div>
</footer>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row">{{ __('アップロード承認') }}</div>
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
                            <div class="div-border">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-3 text-left" style="padding: 5px;"><img class="round-frame-account" src="{{asset('images/images_4.png')}}" width="50" height="50"></div>
                                        <div class="col-5 text-center name-padding"><span style="font-weight: bold;">{{print_r($item->name, true)}}</span></div>
                                        <div class="col-4 text-right"><span class="btn btn-danger p-2" style="font-size:8px;width:70px">非承認</span></div>
                                    </div>
                                </div>
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td class="border-none" rowspan="3" style="width:100px">
                                            <a href="{{asset('storage/upload/' . $dir)}}" target="_blank">
                                                <img class="round-frame" src="{{asset('storage/upload/' . $dir)}}">
                                            </a>
                                        </td>
                                        <td class="border-none text-center" style="width:100px">場所：</td>
                                        <td class="border-none text-center" style="width:100px">{{print_r($item->position, true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">魚種：</td>
                                        <td class="border-none text-center">{{print_r($item->fish_species, true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">サイズ：</td>
                                        <td class="border-none text-center">{{print_r($item->size, true)}}</td>
                                    </tr>
                                </table>
                                <div class="text-right">
                                    <a href="{{route('approval-update', ['id' => $item->id])}}" class="btn btn-success mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">承認する</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="approved-table">
                        @foreach ($approved_fishing_results as $item)
                            @php
                                $arr_file_dir = explode("/", $item->pic);
                                $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
                            @endphp
                            <div class="div-border">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-3 text-left" style="padding: 5px;"><img class="round-frame-account" src="{{asset('images/images_4.png')}}" width="50" height="50"></div>
                                        <div class="col-5 text-center name-padding"><span style="font-weight: bold;">{{print_r($item->name, true)}}</span></div>
                                        <div class="col-4 text-right"><span class="btn btn-success p-2" style="font-size:8px;width:70px">承認</span></div>
                                    </div>
                                </div>
                                <table class="border-none" style="margin: 10px 0px">
                                    <tr class="border-none">
                                        <td class="border-none" rowspan="3" style="width:100px">
                                            <a href="{{asset('storage/upload/' . $dir)}}" target="_blank">
                                                <img class="round-frame" src="{{asset('storage/upload/' . $dir)}}" width="192" height="130">
                                            </a>
                                        </td>
                                        <td class="border-none text-center" style="width:100px">場所：</td>
                                        <td class="border-none text-center" style="width:100px">{{print_r($item->position, true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">魚種：</td>
                                        <td class="border-none text-center">{{print_r($item->fish_species, true)}}</td>
                                    </tr>
                                    <tr class="border-none">
                                        <td class="border-none text-center">サイズ：</td>
                                        <td class="border-none text-center">{{print_r($item->size, true)}}</td>
                                    </tr>
                                </table>
                                <div class="text-right">
                                    <a href="{{route('approval-delete', ['id' => $item->id])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">承認取り消し</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection