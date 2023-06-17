@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">IMPORTANT! SECURITE</h1>
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
		<form method='POST' action="{{ route('bn.register.store',['id' => 'aicha','params' => 'bistronippon']) }}">
		@csrf
		<div class="row gx-1"><!--row 1行目 start-->
		<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="climatiseurs" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Les climatiseurs et les ventilateurs</b>
							<span style="color: red;">facture d'STEG élevée</span>
							<input class="form-check-input ms-2" type="checkbox" id="climatiseurs" name="climatiseurs" value="{{ Session::get('climatiseurs') }}" required>
							</label>
						</div>
						<img src="/img/climatiseurs.png" alt="Your Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="porte_droite" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Porte droite</b>
							<input class="form-check-input ms-2" type="checkbox" id="porte_droite" name="porte_droite" value="{{ Session::get('porte_droite') }}" required>
							</label>
						</div>
						<img src="/img/door1.png" alt="Your Image" class="ms-3" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="fritures" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Les deux friture</b>
							<input class="form-check-input ms-2" type="checkbox" id="fritures" name="fritures" value="{{ Session::get('fritures') }}" required>
							</label>
						</div>
						<img src="/img/flayerKasai.png" alt="Your Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>

			</div><!--row 1行目 end-->

<div class="row gx-1"><!--row 2行目 start-->
<div class="col-md-4">
	<div class="p-3 border bg-light">
		<div class="d-flex align-items-center">
			<div class="flex-grow-1">
				<label for="porte_droite" class="d-flex align-items-center">
				<b style="margin-right:10px;">&#9849;Porte droite</b>
				<input class="form-check-input ms-2" type="checkbox" id="porte_droite" name="porte_droite" value="{{ Session::get('porte_droite') }}" required>
				</label>
			</div>
			<img src="/img/door1.png" alt="Your Image" class="ms-3" style="width: 80px; height: 80px;">
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="p-3 border bg-light">
		<div class="d-flex align-items-center">
			<div class="flex-grow-1">
				<label for="fritures" class="d-flex align-items-center">
				<b style="margin-right:10px;">&#9849;Les deux friture</b>
				<input class="form-check-input ms-2" type="checkbox" id="fritures" name="fritures" value="{{ Session::get('fritures') }}" required>
				</label>
			</div>
			<img src="/img/flayerKasai.png" alt="Your Image" class="ms-1" style="width: 80px; height: 80px;">
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="p-3 border bg-light">
		<div class="d-flex align-items-center">
			<div class="flex-grow-1">
				<label for="climatiseurs" class="d-flex align-items-center">
				<b style="margin-right:10px;">&#9849;Les climatiseurs</b>
				<span style="color: red;">facture d'STEG élevée</span>
				<input class="form-check-input ms-2" type="checkbox" id="climatiseurs" name="climatiseurs" value="{{ Session::get('climatiseurs') }}" required>
				</label>
			</div>
			<img src="/img/climatiseurs.png" alt="Your Image" class="ms-1" style="width: 80px; height: 80px;">
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
</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')