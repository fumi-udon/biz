@extends('layouts.app')
<!-- パンくずリスト -->
@include('layouts.head',['bread_name' => '商品消費'])
@section('content')
<h4>商品消費データ</h4>

<!--container データ表示-->
<div class="container px-4 p-3">
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
	</div><!--row end-->
</div><!--container end-->

<div class="container px-4 p-3">
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<ul class="list-group">
		<li class="list-group-item">
			<a href="/admin">Admin pageへ戻る</a>
		</li>
		</ul>
		</div>
	</div><!--row end-->
</div><!--container end-->
@endsection

@section('footer')
@endsection