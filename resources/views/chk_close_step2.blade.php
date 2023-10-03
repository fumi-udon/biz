@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
@if (Session::has('jesser_close') && session('jesser_close') )
	<p>Hi! Jesser</p>
@endif

	<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">STEP 3</h1>
		<small>Closing Checklist</small>
	</div>
	</div>
	@if (Session::has('action_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-danger" role="alert">
			<p>{!! session('action_message') !!}</p>	
		</div>
	</div>
	@endif
    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
		<form method='POST' action="{{ route('close.garantie',['id' => 'garantie','params' => 'garantie']) }}">
		@csrf

	@if (Session::has('jesser_close') && session('jesser_close') )
		<div class="row gx-1"><!--row 1行目 start-->
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="tasses" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9847;Les tasses</b>
							
							<input class="form-check-input ms-2" type="checkbox" id="tasses" name="tasses" value="{{ Session::get('tasses') }}" required>
							</label>
						</div>
						<img src="/img/tasses.png" alt="tasses image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="porte_droite" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;La porte droite</b>

							<input class="form-check-input ms-2" type="checkbox" id="porte_droite" name="porte_droite" value="{{ Session::get('porte_droite') }}" required>
							</label>
						</div>
						<img src="/img/door1.png" alt="door1 Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<label for="mimo" class="d-flex align-items-center">
						<b style="margin-right:10px;">&#9859;Chats</b>

						<input class="form-check-input ms-2" type="checkbox" id="mimo" name="mimo" value="{{ Session::get('mimo') }}" data-bs-toggle="modal" data-bs-target="#mimoModal" required>
						</label>
						<img src="/img/chats.png" alt="mimo image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
		</div><!--row 1行目 end-->
	@else
		<div class="row gx-1"><!--row 1行目 start-->
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="food" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;la poubelle</b>

							<input class="form-check-input ms-2" type="checkbox" id="poubelle" name="poubelle" value="{{ Session::get('poubelle') }}"  required>
							</label>
						</div>
						<img src="/img/poubelle.png" alt="poubelle Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="food" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;les ingrédients</b>

							<input class="form-check-input ms-2" type="checkbox" id="food" name="food" value="{{ Session::get('food') }}" data-bs-toggle="modal" data-bs-target="#foodModal" required>
							</label>
						</div>
						<img src="/img/food.png" alt="food Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			
			@if (Session::has('bilel_days') && session('bilel_days') )
			<!-- ビレル 火曜水曜木曜のみ -->
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="porte_droite" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;La porte droite</b>

							<input class="form-check-input ms-2" type="checkbox" id="porte_droite" name="porte_droite" value="{{ Session::get('porte_droite') }}" required>
							</label>
						</div>
						<img src="/img/door1.png" alt="door1 Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			@endif
		</div><!--row 1行目 end-->

		@if (Session::has('bilel_days') && session('bilel_days') )
		<!--row 2行目 start-->
		<!-- ビレル 火曜水曜木曜のみ -->
		<div class="row gx-1">
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="tasses" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9847;Les tasses</b>
							
							<input class="form-check-input ms-2" type="checkbox" id="tasses" name="tasses" value="{{ Session::get('tasses') }}" required>
							</label>
						</div>
						<img src="/img/tasses.png" alt="tasses image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<label for="mimo" class="d-flex align-items-center">
						<b style="margin-right:10px;">&#9859;Chats</b>

						<input class="form-check-input ms-2" type="checkbox" id="mimo" name="mimo" value="{{ Session::get('mimo') }}" data-bs-toggle="modal" data-bs-target="#mimoModal" required>
						</label>
						<img src="/img/chats.png" alt="mimo image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
		</div>
		<!--row 2行目 end-->	
		@endif

	@endif

		<!-- 認証エリア -->
		<div class="p-4 border bg-light" style="margin-top:10px;">
			<div class="form-group">
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
		<!-- 認証エリア end-->
			<div class="row p-2">
				<div class="col-md-12">
				<input type="submit" value="confirmer" name="confirmer" class="btn btn-primary btn-round">
				</div>
			</div>
		</form>
	  </div><!--コンテナー end -->
    </div>
</main>

<!-- FUMI end -->
<!-- Modal  start-->
<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="foodModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="foodModalLabel">Attention</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <span style="color: red;">Le riz / udon / légumes ....</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Je garantie</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal  end-->
<!-- Modal Mimo start-->
<div class="modal fade" id="mimoModal" tabindex="-1" aria-labelledby="mimoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mimoModalLabel">Chats</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <img src="/img/mimo.png" alt="mimo image" class="ms-1" style="width: 180px; height: 150px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">MIMO💛 Bon nuit !!</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal  end-->

<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>