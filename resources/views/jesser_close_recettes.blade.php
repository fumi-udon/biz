@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Jesser recettes</h1>
		<small>finance</small>
	</div>
	</div>

	@if(Request::is('jesser_close_recettes_store'))
	 <div class="my-1 p-1">
		<div>
			<p><b>recettes &#x1f30a; </b> {!! $recettes_soir !!}dt ( initial+50dt  / chips+{!! $chips !!}dt) =  {!! $recettes_and_init !!}dt </b></p>
			<p>
			<b>caisse &#x1f39e; </b> cash:{!! $cash !!} + cheque:{!! $cheque !!} + carte:{!! $carte !!}  = {!! $compte_in_caisse !!}dt
			</p>
			@if ( ! $bravo )
				<p  class='p-2'><span style='color: red;'>RESULTAT :  {!! $resultat !!} dt</span></p>
			@endif
		</div>
		<div class="alert my-element {{ $bravo ? 'alert-info' : 'alert-warning' }}" role="alert">
			<p>{!! session('resultat_message') !!}</p>
		</div>
	</div>
	@endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
	  <form method='POST' action="{{ route('jesser.close.recettes.store',['id' => 'jesser_fin','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1">
			<div class="col-md-4">
			<div class="p-3 border bg-light">
				<div class="p-1">
					<h5><u>Le montant initial :  {!! $montant_initial !!}dt</u></h5>
				</div>				
				<div class="col-md-6">
					<div class="form-group">
						<label><b>&#9559; chips</b></label>
						<input type="number" id="chips" name="chips" value="{{ Session::get('chips') }}" class="form-control" step="0.1" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="udon_rest_8h"><b>&#9849; Les recettes pour le soir</b></label>
						<input type="number" id="recettes_soir" name="recettes_soir" value="{{ Session::get('recettes_soir') }}" class="form-control" step="0.1" required>
					</div>
				</div>
				<hr>
				<div class="form-group p-3">
					<label><b>&#9859; caisse</b></label>
					<br>
					cash<input type="number" id="cash" name="cash" value="{{ Session::get('cash') }}" class="form-control" step="0.1" required>
					chèque<input type="number" id="cheque" name="cheque" value="{{ Session::get('cheque') }}" class="form-control" step="0.1" required>
					carte (tickets)<input type="number" id="carte" name="carte" value="{{ Session::get('carte') }}" class="form-control" step="0.1" required>
				</div>
			</div>
			</div>
		</div><!--row end-->
		<div class="row p-2">
				<div class="col-md-12">
					<input type="submit" value="envoyer" name="btn_jsser_env" id='btn_jsser_env' class="btn btn-primary btn-round">
				</div>
		</div><!--row end-->
		</form>
	  </div><!--コンテナー end -->
    </div>
	<!--戻るリンク-->
	<div class="container mt-5 p-3">
		<a href="/jesser_top" class="text-primary">Retour</a>
	</div>

	<!--初期金額変更-->
	<form method='POST' action="{{ route('jesser.close.updatemontan',['id' => 'jesser_up_montan','params' => 'bistronippon']) }}">
	@csrf
	<div style="text-align: right;padding:30px;">
			<p class="m-2 small"><a href="javascript:void(0)" id="up_montan_open" style="color: grey;">changer le montant initial</a></p>
			<div id='elem_update_montant' style='display:none;'>
				<p class="m-2 small"><input type="number" id="update_montant_initial" name="update_montant_initial" value="{{ Session::get('update_montant_initial') }}" step="0.1" required></p>
				<input type="submit" value="update" name="btn_update_mi" id='btn_update_mi' class="btn btn-primary btn-round">
			</div>									
	</div>
	</form>
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/fumi0307.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')