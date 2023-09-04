@extends('layouts.app')
@extends('layouts.head')
@section('content')
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
		<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
		<div class="lh-1">
			<h1 class="h6 mb-0 text-white lh-1">Shift</h1>
		</div>
	</div>
	<div>
		<!-- ここに埋め込みコードを貼り付ける -->
		<iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false"  width="100%" height="100%" frameborder="0"></iframe>
	</div>
	<a href='https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=0&single=true'>
			link </a>
</main>
<!--インライングリッド row end -->

@endsection
@extends('layouts.footer')