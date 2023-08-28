@extends('layouts.app')
@extends('layouts.head')
@section('content')
<main class="container">
<h4>指示登録完了ページ / complete addnote</h4>
@if (Session::has('action_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-success" role="alert">
			<p>{!! session('action_message') !!}</p>
			<p><b>登録データ</b></p>
			<p>表示日: {!! session('note_date') !!}</p>
			<p>{!! session('note8h') !!}</p>
		</div>
	</div>
@endif
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="width: 80%;">
		<div class=" text-muted">
			<a href="/" class="text-primary">Retour</a>
		</div>
	</div>
</main>
<!--インライングリッド row end -->
@endsection

@extends('layouts.footer')