@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">jesser_gestion_stock</h1>
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
		</form>
	  </div><!--コンテナー end -->
    </div>
	<!--戻るリンク-->
	<div class="container mt-5">
		<a href="/jesser_top" class="text-primary">Retour</a>
	</div>
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')