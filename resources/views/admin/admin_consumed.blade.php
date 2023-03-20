@extends('layouts.app')
<!-- パンくずリスト -->
@extends('layouts.head')
@section('content')
<!--fumi new start-->
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-pink rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">食材消費履歴</h1>
		<small>consomation</small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded shadow-sm">
	<div class=" text-muted pt-3 pb-3">
		{{-- 通常指示 --}}
		<!--日付入力エリア-->
		{{-- 日付 対象商品入力 --}}
		<form action="search" method="post">
		@csrf
		<div class="form-group">
			<div class="input-group col-sm-3 m-1">
				<span class="input-group-text" id="basic-addon3">SHOP</span>
				<select class="form-select" id="shop_list" name="shop_list" required>
				@foreach ($shops as $shop)
					<option value="{{ $shop['id'] }}" @if( Session::get('shop_now')  == $shop['id'] ) selected @endif> {{ $shop['name'] }} </option>
				@endforeach
				</select>      
			</div>
		</div>

		<div class="form-group">
			<div class="input-group col-sm-3 m-1">
				<span class="input-group-text" id="basic-addon3">DATE</span>
				<input type="date" id="input_date" name="input_date" 
						value="{{ Session::get('input_date') }}" class="form-control" 
						placeholder="日付入力してください" aria-label="" aria-describedby="basic-addon1" required>
			</div>
			<div class="input-group col-sm-2 m-1">
				<button class="btn btn-info" type="submit" id='btn_emp' name='btn_emp' >Get data!</button>				           
			</div>		
		</div>
		</form>
	</div>
	{{-- 検索結果表示 start BistroNippon --}}
	@if(Request::is('search') && Session::get('shop_now')  == 'main' )
	<div class="d-flex text-body pt-1">
		<!--container データ表示-->
		<div class="container">
			<div class="row gy-3">
				<div class="col-md-12">
				<h4>Ramen消費数: {{ $total_qty_rmn }} </h4>
				<p class="m-2"><a href="javascript:void(0)" id="rmn_open">詳細</a> <a href="javascript:void(0)" id="rmn_close">Close</a></p>
				<table class="table" id="rmn_record" style="display:none;">
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
			<div class="row gy-3">
			<div class="col-md-12">
				<h4>Udon消費数: {{ $total_qty_udn }}</h4>
				<p class="m-2"><a href="javascript:void(0)" id="udn_open">詳細</a> <a href="javascript:void(0)" id="udn_close">Close</a></p>
				<table class="table" id="udn_record" style="display:none;">
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
			<div class="row gx-3">
				<div class="col-md-4 center-block">
				<h4>Paiko消費数カウント</h4>
				@foreach ($paikos_ary as $key => $val)
					<p>{{ $key }}:{{ $val }}</p>
				@endforeach
				</div>
			</div><!--row end-->
			<hr>
			<div class="row gx-3">
				<div class="col-md-4 center-block">
				<h4>米消費:&#x1f35a; {{ $riz_grammes_total }} グラム / {{ number_format($riz_grammes_total / 330, 1) }}合</h4>
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
			</div><!--row end riz_g-->
			<div class="row gx-3">
				<div class="col-md-4 center-block">
				<h4>エクストラ検索</h4>
				@foreach ($extra_collect as $item)
					@foreach ($item as $key => $val)
						<p>{{ $key }} : {{ $item[$key] }}</p>
					@endforeach
				@endforeach
				</div>
			</div><!--row end-->
			<div class="row gx-3">
				<div class="col-md-4 center-block">
				<h4>商品消費量</h4>
				@foreach ($product_collect as $item)
					@foreach ($item as $key => $val)
						<p>{{ $key }} : {{ $item[$key] }}</p>
					@endforeach
				@endforeach
				</div>
			</div>
			<div class="row gx-3">
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
	{{-- 検索結果表示 BistroNippon END--}}

	{{-- 検索結果表示 CurryKitano start --}}
	@if(Request::is('search') && Session::get('shop_now')  == 'currykitano' )
		<div class="text-body ms-3 w-50">
			<hr>
			<h6>消費量</h6>
			<ul class="list-group list-group-flush">
			@foreach ($product_collect as $item)
				@foreach ($item as $key => $val)
					<li class="list-group-item d-flex justify-content-between align-items-center">
						{{ $key }}
						<span class="badge badge-primary badge-pill" style="background-color: blue !important; color: white !important;">{{ $item[$key] }}</span>
					</li>
				@endforeach
			@endforeach
			</ul>
		</div>
	@endif
	{{-- 検索結果表示 CurryKitano end --}}	
</div>
</main>
<!--fumi new end-->
@endsection
@extends('layouts.footer')
