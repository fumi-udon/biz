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
			<a class="btn btn-dark btn-sm" id="start_zoom" role="button" href="javascript:void(0)"> Get meeting link </a>
			<p id="zoom_link_area" style="display:none; width: 100%;padding:20px;">
				<a class="" id="zoom_link" href="https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1"> https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1 </a>
			<p>
		</div>
	</div>
	<!-- @php
		session()->forget('jesser_close');
	@endphp -->
@else
	<div><a href="/">Retour au top page</a></div>
@endif
</main>

<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>