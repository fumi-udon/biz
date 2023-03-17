@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">直近オーダーデータ表示</h1>
		<small>order data</small>
	</div>
</div>
<div class="my-3 p-3 bg-body rounded">
	@if(@$action_message)
	<!-- アクションメッセージ表示 -->
	<div class="alert alert-success" role="alert">
	<p>{{ $action_message }}</p>
	</div>
	@endif

	{{-- 通常指示 --}}
	<!--日付入力エリア-->
	<div class="row gx-3">

		<div class="col-md-12 center-block p-1">
		{{-- 日付 対象商品入力 --}}
		<form id='form_emp1' action="{{ route('search.index') }}" method="post" class="mx-1">
		@csrf		
			<div class="form-group d-flex">
				<div class="col-sm-2 m-1">
					<select class="form-select" id="type_list" name="type_list" required>
						@foreach ($types as $type)
							<option value="{{ $type['id'] }}" @if( Session::get('type_now')  == $type['id'] ) selected @endif> {{ $type['name'] }} </option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-4 m-1">
					<select class="form-select" id="shop_list" name="shop_list" required>
						@foreach ($shops as $shop)
							<option value="{{ $shop['id'] }}" @if( Session::get('shop_now')  == $shop['id'] ) selected @endif> {{ $shop['name'] }} </option>
						@endforeach
					</select>
				</div>             
			</div>

			<div class="form-group">
				<div class="input-group col-sm-2 m-1">
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
	</div>
</div>

	{{-- 検索結果表示 start--}}
	@if(Request::is('emporter_search'))
	<div class="my-3 p-3 bg-body rounded">
		<div class="row gx-3">
			<div class="col-md-12 center-block p-3">
				検索結果
				<p>
			@if(isset($result))
				<table class="table">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Printed datetime</th>
					<th scope="col">TableNo</th>
					<th scope="col">Name</th>
					<th scope="col">Product</th>
					<th scope="col">Ingredients</th>
					<th scope="col">Qantity</th>
					</tr>
				</thead>
				@foreach($result as $array)
				<tbody>
					<tr>
					<td>{{ $array['printed_datetime'] }}</td>
					<td>{{ $array['table_number'] }}</td>
					<td>{{ $array['name'] }}</td>
					<td>{{ $array['product_name_for_staff'] }} _ {{ $array['product_type_name_for_staff'] }}</td>
					<td>{{ $array['ingredients'] }}</td>
					<td>{{ $array['qty'] }}</td>
				</tbody>
				@endforeach		
				</table>	
			@else
				<br>無し _ no data<br>
			@endif
				</p>
			</div>
		</div>
	@endif
	</div>

</main>
@endsection

@extends('layouts.footer')