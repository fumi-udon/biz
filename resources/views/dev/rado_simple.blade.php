
@extends('layouts.app')
@extends('layouts.head')

@section('content')
<div class="row gy-3 px-3">
    <div class="p-2 col-md-12">
    <h4>売上合計</h4>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">年月</th>
            <th scope="col">金額（DT）</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($recettes_months as $recette) 
        <tr>
            @foreach ($recette as $month => $total) 
            <th scope="row">{{ $month }}</th>
            <td>{{ $total }} DT</td>         
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>

<div class="row gy-3 px-3">
    <div class="p-2 col-md-12">
    <h4>Ramen消費数カウント: {{ $total_qty }}</h4>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">注文番号</th>
            <th scope="col">注文日</th>
            <th scope="col">商品名</th>
            <th scope="col">タイプ</th>
            <th scope="col">数</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($ramen_datas as $datas)
        <tr>
            <td>{{ $datas['order_id'] }}</td>
            <td>{{ $datas['formatted_date'] }}</td>
            <td>{{ $datas['product_name_for_staff'] }}</td>
            <td>{{ $datas['product_type_name_for_staff'] }}</td> 
            <td>{{ $datas['qty'] }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
@extends('layouts.footer')