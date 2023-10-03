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
	<div><p>RESPONSABLE: {!! $close_name !!}</p><p>Heure de check: {!! $formattedDate !!}</p></div>

@if (Session::has('jesser_close') && session('jesser_close') )

	<div class="row p-2">
		<div class="col-12 col-sm-6"> <!-- レスポンシブ対応の列幅指定 -->
			Rejoindre un meeting à 22h50
			<p id="zoom_link_area" style="width: 100%;padding:20px;">
				<a class="" id="zoom_linkreturn" href="/jesser_top"> Aller J management </a>
			<p>
		</div>
	</div>
	@php
		session()->forget('jesser_close');
	@endphp
@else
	<div><a href="/">Retour au top page</a></div>
@endif
</main>

<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>