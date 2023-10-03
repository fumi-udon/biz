@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h5 mb-0 text-white lh-1"><b>Meeting start from 22:50</b></h1>
		<small></small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded">
@if (Session::has('zoom_ok') && session('zoom_ok') )
	<div class="col-12 col-sm-8"> <!-- レスポンシブ対応の列幅指定 -->
		<p>Rejoindre une réunion :</p>
        <p id="zoom_link_area" style="width: 100%; padding:10px;">
            <a class="" id="zoom_link" href="https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1"> https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1 </a>
        <p>
    </div>
@else
	<div class="alert alert-primary" role="alert">
			<p>{!! session('flash_message') !!}</p>			
	</div>
@endif
</div>

</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>