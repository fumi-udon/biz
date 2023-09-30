@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	@if (Session::has('jesser_close') && session('jesser_close') )
		<p>Hi! Jesser</p>	
	@endif
	<div class="d-flex align-items-center p-3 my-3 text-white bg-pink rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">STEP 1</h1>
		<small>Closing Checklist</small>
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
		<form method='POST' action="{{ route('close.step2',['id' => 'step2','params' => 'steg']) }}">
		@csrf

		<div class="row gx-1"><!--row 1行目 start-->
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="frigos" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9847;Les portes de frigos et congérateurs</b>
							
							<input class="form-check-input ms-2" type="checkbox" id="frigos" name="frigos" value="{{ Session::get('frigos') }}" required>
							</label>
						</div>
						<img src="/img/frigos.png" alt="frigos" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="climatiseurs" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Climatiseurs / Ventilateurs / Chauffage</b>

							<input class="form-check-input ms-2" type="checkbox" id="climatiseurs" name="climatiseurs" value="{{ Session::get('climatiseurs') }}" data-bs-toggle="modal" data-bs-target="#climatiseursModal" required>
							</label>
						</div>
						<img src="/img/climatiseurs.png" alt="flayerKasai Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
		</div><!--row 1行目 end-->

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
<!-- Modal friture start-->
<div class="modal fade" id="climatiseursModal" tabindex="-1" aria-labelledby="climatiseursModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="climatiseursModalLabel">Attention</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <span style="color: red;">Faites attention : factures d'électricité élevées</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Je garantie</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal friture end-->

<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>