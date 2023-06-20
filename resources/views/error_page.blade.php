@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">	
	@if (Session::has('error_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-danger" role="alert">
			<h1>ERROR !!</h1>
			<p>{!! session('error_message') !!}</p>	
			<div>NOW: {!! session('formattedDate') !!}</div>
		</div>		
	</div>
	@endif

	<div><a href="/">Retour</a></div>
</main>

<!--テスト　デバック-->
@endsection
@extends('layouts.footer')
