@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Bonsoir Aicha ! 15H</h1>
		<small>enregistrer</small>
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
		<form method='POST' action="{{ route('bn.register.store',['id' => 'aicha','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1">
			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="rizs_list"><b>&#9849;UDON </b>  <br>reste pour ce soir?
					<input type="number" id="udon_rest_8h" name="udon_rest_8h" min="0" max="19" value="{{ Session::get('udon_rest_8h') }}" class="form-control is-valid w20" required>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="rizs_list"><b>&#9859;Riz </b><br>saisir une quantité précise
					<select class="form-select" id="rizs_list" name="rizs_list" required>
						@foreach ($rizs as $riz)
							<option value="{{ $riz['id'] }}" @if( Session::get('riz_now')  == $riz['id'] ) selected @endif> {{ $riz['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="bouillons_list"><b>&#9969;Bouillons</b> <br> combien de litre?
					<select class="form-select" id="bouillons_list" name="bouillons_list" required>
						@foreach ($bouillons as $bouillon)
							<option value="{{ $bouillon['id'] }}" @if( Session::get('bouillon_now')  == $bouillon['id'] ) selected @endif> {{ $bouillon['name'] }} </option>
						@endforeach
					</select>
					</label>
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
        <!--aicha_works_topに戻るリンク-->
        <div class="container mt-5">
            <a href="/aicha_works_top" class="text-primary">Retour</a>
        </div>
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
			<h5>StockIngredientテーブル / flg 1 </h5>
			<div class="table-responsive">			
			<table class="table">
				<thead>
					<tr>
					<th scope="col">date</th>
					<th scope="col">udon 15h</th>
					<th scope="col">riz</th>
					<th scope="col">bouillons</th>

					</tr>
				</thead>
				<tbody>
				@foreach ($stock_ingredients as $stock_ingredient)
					<tr>
					<td>{{ $stock_ingredient->registre_datetime }}</td>
					<td>{{ $stock_ingredient->udon_rest_15h }}</td>
					<td>{{ $stock_ingredient->article1_rest }}</td>
					<td>{{ $stock_ingredient->article2_rest }}</td>
				
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
		</div>
		@endif
		<!-- Bilel登録データ end-->
	</div>
<!-- Note 入力エリア end-->

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>