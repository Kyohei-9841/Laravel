@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ランキング') }}</div>
                <div class="card-body">
                    @foreach ($fishing_results as $item)
                        @php
                            $arr_file_dir = explode("/", $item->pic);
                            $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
                        @endphp
                        <div class="div-border">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-3 text-left" style="padding: 5px;"><img class="round-frame-account" src="{{asset('images/images_4.png')}}" width="50" height="50"></div>
                                    <div class="col-5 text-center name-padding"><span style="font-weight: bold;">{{print_r($item->name, true)}}</span></div>
                                    <div class="col-4 text-right">
                                    </div>
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
                        </div>
                    @endforeach                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
