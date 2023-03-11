@extends('layouts.app')
<!-- パンくずリスト -->
@include('layouts.head',['bread_name' => '財務'])
@section('content')
<h4>財務</h4>

<!--container 売上データ表示-->
<div class="container px-4 p-3">
<div class="row gx-3">
	<div class="col-md-12 center-block p-3">
	{{-- 日付 対象商品入力 --}}
	<form action="finance" method="post">
	@csrf		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<button class="btn btn-outline-secondary" type="submit">売上表示</button>
			</div>
			<div class="input-group-prepend px-4">
				<select class="form-select" id="shop_list" name="shop_list" required>
					@foreach ($shops as $shop)
						<option value="{{ $shop['id'] }}" @if( Session::get('shop_now')  == $shop['id'] ) selected @endif> {{ $shop['name'] }} </option>
					@endforeach
				</select>
		    </div>
		</div>
		<input type="hidden" name="actual_page_id" id="actual_page_id" value="finance_search">
	</form>
	</div>
</div>
@if(Request::is('finance'))
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
			@foreach ($totals_ary as $month => $total) 
				<tr>
					<th scope="row">{{ $month }}</th>
					<td>{{ $total }} DT</td>         
				</tr>
			@endforeach
			</tbody>
		</table>
		</div>
	</div>
</div><!--container end-->
@endif
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