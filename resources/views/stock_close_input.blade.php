@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Bonsoir BILEL! pour la fermeture </h1>
		<small>check stock data</small>
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
		<form method='POST' action="{{ route('stock.close.store',['id' => 'fermeture','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1">
			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="chashu"><b>&#129410;Cha-shu </b>  <br>combien de morseaux restes?
					<input type="number" id="chashu" name="chashu" min="0" max="8" value="{{ Session::get('chashu') }}" class="form-control is-valid w20" required>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="paikos_list"><b>&#129372;Paiko </b> <br> boîte en inox de paiko
					<select class="form-select" id="paikos_list" name="paikos_list" required>
						@foreach ($paikos as $paiko)
							<option value="{{ $paiko['id'] }}" @if( Session::get('paiko_now')  == $paiko['id'] ) selected @endif> {{ $paiko['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			</div>

			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="poulet_crus_list"><b>&#128020;Poulet crus</b> <br> combien de poulet crus?
					<select class="form-select" id="poulet_crus_list" name="poulet_crus_list" required>
						@foreach ($poulet_crus as $poulet_cru)
							<option value="{{ $poulet_cru['id'] }}" @if( Session::get('poulet_cru_now')  == $poulet_cru['id'] ) selected @endif> {{ $poulet_cru['name'] }} </option>
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
					<label for="rizs_list"><b>&#127834;Riz </b><br> saisir une quantité précise
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
					<label for="laits_list"><b>&#129370;Laits </b> <br>combien de paquet?
					<select class="form-select" id="laits_list" name="laits_list" required>
						@foreach ($laits as $lait)
							<option value="{{ $lait['id'] }}" @if( Session::get('lait_now')  == $lait['id'] ) selected @endif> {{ $lait['name'] }} </option>
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
	@if(Request::is('addnote_courses'))
	<hr>
	<p class="p-3"><b>登録しました。flg=4</b><br>表示日：{{ session('note_date') }}<br>{{ session('note8h') }}</p>
	@endif
	<div style="text-align: right;">
		<p class="m-2 small"><a href="javascript:void(0)" id="note_open" style="color: grey;">詳細</a></p>
	</div>
	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 100%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('addnote.courses') }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 _ 例:&#128019; Poulet  x pièces @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp &#129371; Lait  4 paquets</label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="alice_btn">登録</button>
		</form>
		</div><!--row end -->
		<!-- sato独自指示 エリア end -->

		<!-- Bilel登録データ -->
		@if ( isset($stock_ingredients) )
		<div class="my-3">
			<div class="">
			<B>Bilel登録データ StockIngredientテーブル / flg 2 </B><br>

			<div class="table-responsive">	
			<table class="table">
				<thead>
					<tr>
					<th scope="col">registre_datetime</th>
					<th scope="col">chashu</th>
					<th scope="col">paiko</th>
					<th scope="col">poulet_cru</th>
					<th scope="col">lait</th>
					<th scope="col">riz</th>
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
		</div>
		@endif
		<!-- Bilel登録データ end-->
	</div>
<!-- Note 入力エリア end-->
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')