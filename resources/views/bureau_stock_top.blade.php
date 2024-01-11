@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Bureau stocke gestionaire</h1>
		<small>vérifier des restes des ingrédients à la fin de travail</small>
	</div>
	</div>
	@if (Session::has('flash_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-success" role="alert">
			<p>{!! session('flash_message') !!}</p>	
		</div>
	</div>
	@endif
    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
		<form method='POST' action="{{ route('bureau.stock.store',['id' => '4','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1">
			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="article1s"><b>&#128017;Boîte de ramen vide</b>
					<select class="form-select" id="article1s" name="article1s" required>
						@foreach ($article1s as $article1)
							<option value="{{ $article1['id'] }}" @if( Session::get('article1_now')  == $article1['id'] ) selected @endif> {{ $article1['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="article2s"><b>&#128017;Boîte de ramen pleine</b>
					<select class="form-select" id="article2s" name="article2s" required>
						@foreach ($article2s as $article2)
							<option value="{{ $article2['id'] }}" @if( Session::get('article2_now')  == $article2['id'] ) selected @endif> {{ $article2['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="article4s"><b>&#128017;Bols de udon</b> <br> compter le aprés descendre 
					<select class="form-select" id="article4s" name="article4s" required>
						@foreach ($article4s as $article4)
							<option value="{{ $article4['id'] }}" @if( Session::get('article4_now')  == $article4['id'] ) selected @endif> {{ $article4['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			</div>

			</div><!--row end-->

			<div class="row gx-1">

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="article3s"><b>&#128017;poudre du mais </b>
					<select class="form-select" id="article3s" name="article3s" required>
						@foreach ($article3s as $article3)
							<option value="{{ $article3['id'] }}" @if( Session::get('article3_now')  == $article3['id'] ) selected @endif> {{ $article3['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			</div>

			</div><!--row end-->

			<div class="row p-2">
				<div class="col-md-12">
				<input type="submit" value="enregistrer" name="enregistrer" class="btn btn-primary btn-round">
				</div>
			</div><!--row end-->
		</form>
	  </div><!--コンテナー end -->
    </div>

	<!-- Note 入力エリア ◆通常は非表示 start-->
	<div class="col-md-12">
		<div style="text-align: right;">
			<p class="m-2 small"><a href="javascript:void(0)" id="note_open" style="color: grey;">詳細</a></p>
		</div>
		<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 100%;">
			<!-- 登録データ -->
			@if ( isset($stock_ingredients) )
			<div class="">
				<h5>StockIngredientテーブル / flg 4 </h5>
				<div class="table-responsive">			
				<table class="table">
					<thead>
						<tr>
						<th scope="col">date</th>
						<th scope="col">ramen空箱</th>
						<th scope="col">ramen満タン</th>
						<th scope="col">maïs</th>
						<th scope="col">udon</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($stock_ingredients_display as $record)
						<tr>
							@foreach ($record as $value)
								<td>{{ $value }}</td>
							@endforeach
						</tr>
					@endforeach
					</tbody>
				</table>
				</div>
			</div>
			@endif
			<!-- 登録データ end-->
		</div>
	<!-- Note 入力エリア end-->

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')