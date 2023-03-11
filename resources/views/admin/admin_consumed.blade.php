@extends('layouts.app')
<!-- パンくずリスト -->
@include('layouts.head',['bread_name' => '商品消費'])
@section('content')
<h4>商品消費データ</h4>
{{-- 通常指示 --}}
<!--日付入力エリア-->
<div class="row gx-3">
	<div class="col-md-12 center-block p-3">
	{{-- 日付 対象商品入力 --}}
	<form action="search" method="post">
	@csrf		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<button class="btn btn-outline-secondary" type="submit">Submit</button>
			</div>
			<input type="date" id="input_date" name="input_date" 
				value="{{ Session::get('input_date') }}" class="form-control" 
				placeholder="日付入力してください" aria-label="" aria-describedby="basic-addon1" required>
		</div>
		<input type="hidden" name="actual_page_id" id="actual_page_id" value="search_post">
	</form>
	</div>
</div>
{{-- 検索結果表示 start--}}
@if(Request::is('search'))
<hr>
<!--container データ表示-->
<div class="container px-4 p-3">
	<div class="row gy-3 px-3">
		<div class="p-2 col-md-12">
		<h4>Ramen消費数カウント: {{ $total_qty_rmn }}</h4>
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
	<hr>
	<div class="row gy-3 px-3">
		<div class="p-2 col-md-12">
		<h4>Udon消費数カウント: {{ $total_qty_udn }}</h4>
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
			@foreach ($udon_datas as $datas)
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
	<hr>
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<h4>Paiko消費数カウント</h4>
		@foreach ($paikos_ary as $key => $val)
			<p>{{ $key }}:{{ $val }}</p>
		@endforeach
		</div>
	</div><!--row end-->
	<hr>
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<h4>米消費</h4>
		@foreach ($riz_resultats as $item)
			@foreach ($item as $key => $val)
				<p>{{ $key }} : {{ $item[$key] }}</p>
			@endforeach
		@endforeach
		<p><u>[ Extra_米 ]</u></p>
		@foreach ($extra_collect as $item)
			@foreach ($item as $key => $val)
			@if( $key == 'riz')
			<p>{{ $key }} : {{ $item[$key] }}</p>
			@endif				
			@endforeach
		@endforeach
		</div>
	</div><!--row end-->
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<h4>エクストラ検索</h4>
		@foreach ($extra_collect as $item)
			@foreach ($item as $key => $val)
				<p>{{ $key }} : {{ $item[$key] }}</p>
			@endforeach
		@endforeach
		</div>
	</div><!--row end-->
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<h4>商品消費量</h4>
		@foreach ($product_collect as $item)
			@foreach ($item as $key => $val)
				<p>{{ $key }} : {{ $item[$key] }}</p>
			@endforeach
		@endforeach
		</div>
	</div>
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<h4>餃子消費量</h4>
		@foreach ($gyoza_collect as $item)
			@foreach ($item as $key => $val)
				<p>{{ $key }} : {{ $item[$key] }} 個</p>
			@endforeach
		@endforeach
		</div>
	</div><!--row end--><!--row end-->
</div><!--container end paikos_ary -->
@endif
{{-- 検索結果表示 END--}}
@endsection


@section('footer')
@endsection