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
                    @endforeach                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
