@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-recettes rounded shadow-sm">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">Journal  ({!! $todayDate !!})</h1>
        </div>
    </div>

    <div class="my-1 bg-body rounded shadow-sm">
    <div class="container">
        <div class="alert my-element {{ $auth_ok ? 'alert-info' : 'alert-warning' }}" role="alert">
            <p><b><font color="red">{!! $alert_message !!}</font></b></p>
			@if ( $auth_ok )
				<p><b>Total : {!! $journal_recettes !!} dt </b></p>
                <p> _ Lunch  : {!! $total_lunch!!} dt</p>
                <p> _ Diner : {!! $total_diner !!} dt</p>
			@endif
		</div>
    </div>
    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

