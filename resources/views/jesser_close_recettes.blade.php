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
	@if (Session::has('action_message') && !$auth_flg)
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-danger" role="alert">
			<p>{!! session('action_message') !!}</p>	
		</div>
	</div>	
	@elseif(Request::is('jesser_close_recettes_store'))
	 <div class="my-1 p-1">
		<div>
			@if ( ! $bravo )
				<p><b>recettes &#x1f30a; </b> {!! $recettes_soir !!}dt ( initial +50dt ) =  {!! $recettes_and_init !!}dt </b></p>
				<p>
				<b>caisse &#x1f39e; </b> cash:{!! $cash !!} + cheque:{!! $cheque !!} + carte:{!! $carte !!}  = {!! $compte_in_caisse !!}dt
				</p>			
				<p>
					<span style='color: blue;'>RESULTAT :  {!! $resultat_no_chips !!} dt</span>
					<p>&#9559; Pourboires reçus: {{ Session::get('chips') }} dt</p>
				</p>
			@endif
		</div>
		<div class="alert my-element {{ $bravo ? 'alert-info' : 'alert-warning' }}" role="alert">
			<p>{!! session('resultat_message') !!}</p>
			@if ( $bravo )
				<b>Pourboire: {!! $chips !!}dt &#x1f388;</b>
			@endif
		</div>
	</div>
	@endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
	  <form method='POST' action="{{ route('jesser.close.recettes.store',['id' => 'jesser_fin','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1">
			<div class="col-md-8">
			<div class="p-3 border bg-light">			
				<div class="p-1">					
					<label for="fuseau_horaires_list"><b>&#9551;fuseaux horaires </b>
					<select class="form-select" id="fuseau_horaires_list" name="fuseau_horaires_list" required>
						@foreach ($fuseau_horaires as $fuseau_horaire)
							<option value="{{ $fuseau_horaire['id'] }}" @if( Session::get('fuseau_horaires_now')  == $fuseau_horaire['id'] ) selected @endif> {{ $fuseau_horaire['name'] }} </option>
						@endforeach
					</select>				
					</label>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label><b>&#9559; chips</b></label>
						<input type="number" id="chips" name="chips" value="{{ Session::get('chips') }}" class="form-control" step="0.1" required>
					</div>
				</div>
				<hr>
				<div class="p-1">
					<h5><u>Le montant initial :  {!! $montant_initial !!}dt</u></h5>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="recettes_soir"><b>&#9849; Les recettes</b></label>
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

				<!-- 認証エリア -->
				<div class="form-group p-3">
				<label for="close_names_list"><b>&#9851;Responsable </b>
				<select class="form-select" id="close_names_list" name="close_names_list" required>
					@foreach ($close_names as $close_name)
						<option value="{{ $close_name['id'] }}" @if( Session::get('close_name_now')  == $close_name['id'] ) selected @endif> {{ $close_name['name'] }} </option>
					@endforeach
				</select>				
				</label>
				<label for="input_pass">password
					<input type="password" value="" name="input_pass" id="input_pass" required>
				</label>
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

<!-- このエリア ◆通常は非表示 start-->
<div class="col-md-12">
	<div style="text-align: left;padding-top:30px;">
		<div class="input-group mb-1 small" style="width: 120px;">
			<input type="password" id="password_record" name="password_record" class="form-control" value="" style="width:4em;"  maxlength="4" required >
			<button type="submit" name="btn_password_record" id="btn_password_record" class="btn btn-light btn-round">F生誕</button>
		</div>
	</div>

	@if(!empty($finance_records))
	<div class="table-responsive" id="note_record" style="display:none; width: 100%;">
	&#11093; finance
	<table class="table table-striped" sytle ="min-width: 800px;">
		<thead>
			<tr>
				<th>Name</th>
				<th>AM/PM</th>
				<th>[Resultat]</th>
				<th>Recettes data</th>
				<th>Recettes(+init)</th>
				<th> _ init</th>
				<th>Chips</th>
				<th>Caisse Total</th>
				<th> _ cash</th>
				<th> _ cheque</th>
				<th> _ card</th>
				<th>Date time</th>
			</tr>
		</thead>
		<tbody>
			@foreach($finance_records as $record)
				<tr>
					<td>{{ $record->name }}</td>
					<td>{{ $record->zone }}</td>
					<td>{{ $record->montant_1 }}</td>
					<td>{{ $record->recettes_main }}</td>
					<td>{{ $record->recettes_sub }}</td>
					<td>{{ $record->montant_init }}</td>
					<td>{{ $record->chips }}</td>
					<td>{{ $record->caisse }}</td>
					<td>{{ $record->cash }}</td>
					<td>{{ $record->cheque }}</td>
					<td>{{ $record->card }}</td>
					<td>{{ $record->registre_datetime }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	@endif

</div>
<!-- Note 入力エリア end-->

<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/fumi0307.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')