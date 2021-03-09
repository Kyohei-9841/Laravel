@extends('layouts.app')

@section('content')
<footer class="fixed-bottom" style="background-color: transparent;">
	<div class="row">
		<div class="col-9"></div>
		<div class="col-3" align="left">
			<a href="{{route('upload', ['id' => Auth::user()->id])}}" class="btn btn-primary" style="box-shadow: 3px 3px 4px -2px black"><i class="now-ui-icons arrows-1_cloud-upload-94"></i></a>
		</div>
	</div>
</footer>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="container-fluid">
                        <div class="row">{{ __('あなたの釣果一覧') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($fishing_results as $item)
                        @php
                            $arr_file_dir = explode("/", $item->pic);
                            $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
                        @endphp
                        <div class="div-border">
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
                                <a href="{{route('delete', ['id' => $item->id])}}" class="btn btn-danger mr-3" style="font-size:10px;box-shadow: 3px 3px 4px -2px black;">削除</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
