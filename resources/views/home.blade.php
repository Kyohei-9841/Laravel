@extends('layouts.app')

@section('content')
<div class="container">
    <div style="text-align:center;">
        <h1>ユーザー画面</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="content">
                    <form action="{{ asset('pay') }}" method="POST">
                        {{ csrf_field() }}
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ env('STRIPE_KEY') }}"
                            data-amount="1000"
                            data-name="Stripe Demo"
                            data-label="決済をする"
                            data-description="Online course about integrating Stripe"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="JPY">
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($fishing_results as $item)
        @php
            $arr_file_dir = explode("/", $item->pic);
            $dir = $arr_file_dir[2] . "/" . $arr_file_dir[3]
        @endphp
        <div>
            <table border="2" style="margin: 10px 0px">
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
            <a href="{{route('delete', ['id' => $item->id])}}" class="login-button">削除</a>
        </div>
    @endforeach
    <div>
        <a href="{{route('upload', ['id' => Auth::user()->id])}}" class="login-button">アップロード</a>
    </div>
</div>
@endsection
