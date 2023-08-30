@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<h4>登録完了</h4>
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-primary" role="alert">
			<p>{!! session('action_message') !!}</p>		
		</div>
		<div class="">
			<p>登録:</p>
			<p>表示日：{!! session('note_date') !!}</p>
			<p>表内容：{!! session('note8h') !!}</p>	
			<p>フラグ：{!! session('mode_insert_now') !!}</p>	
		</div>
	</div>
</main>
@endsection
@extends('layouts.footer')
