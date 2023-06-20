@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	@if (Session::has('flash_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-primary" role="alert">
			<p>{!! session('flash_message') !!}</p>
			
		</div>
	</div>
	@endif
	<div><p>RESPONSABLE: {!! $close_name !!}</p><p>Heure de départ: {!! $formattedDate !!}</p></div>
	<div><a href="/">Retour</a></div>
</main>


<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>