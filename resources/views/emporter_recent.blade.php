@extends('layouts.app')
@include('layouts.head',['bread_name' => '直近アンポルテ'])
<!-- パンくずリスト -->

@section('content')
<h4>emporter_recent page </h4>
{{-- 通常指示 --}}
<!--日付入力エリア-->
<div class="row gx-3">
@if(@$action_message)
<!-- アクションメッセージ表示 -->
<div class="alert alert-success" role="alert">
  <p>{{ $action_message }}</p>
</div>
@endif
	<div class="col-md-12 center-block p-3">
	{{-- 日付 対象商品入力 --}}
	<form action="emporter_search" method="post">
	@csrf		
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<button class="btn btn-outline-secondary" type="submit">今すぐ知りたい</button>
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
@if(Request::is('emporter_search'))
<div class="row gx-3">
	<div class="col-md-12 center-block p-3">
        検索結果
        <p>
	@if(isset($result))
		<table class="table">
		<thead class="thead-dark">
			<tr>
			<th scope="col">Name</th>
			<th scope="col">Product</th>
			<th scope="col">Ingredients</th>
			<th scope="col">Qantity</th>
			</tr>
		</thead>
		@foreach($result as $array)
		<tbody>
			<tr>
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
<!--テスト　デバック-->

@endsection

@section('footer')
@endsection