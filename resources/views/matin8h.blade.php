@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- @Fumi old -->
<!-- @Fumi old end-->

<main class="container">
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<h6 class="border-bottom pb-2 mb-0">Bonjour Chantal ! &#128536;</h6>
	<div class="d-flex text-muted pt-3">
		<p class="pb-3 mb-0 small lh-sm border-bottom">
	@if (@$yes_sato)
		{{-- サト指示があった場合 --}}
		&#x1f308;{!! $sato_instruction['override_tx_1'] !!}
	@else
	{{-- 通常入力 --}}
		<form action="task8h" method="post">
		@csrf
			<p style='padding:10px;'>
			Combien d'udon dans le frigo? <br>
			<input style="margin-right:5px;" type="number" id="rest_udn" name="rest_udn" min="0" max="25" value="{{ Session::get('rest_udn') }}" required>
			<input type="submit" value="suivant" class="btn btn-primary btn-round">
			<input type="hidden" name="actual_page_id" id="actual_page_id" value="matin8h_page1">
			</p>
		</form>
	@endif	
		</p>
	</div>
	@if(Request::is('task8h'))
	<!--task8hのページのみ表示  -->
	{{-- 通常指示 --}}
	<div class="text-muted pt-3">
		<p class="pb-3 mb-0 small lh-sm border-bottom">            
			<p><b>&#129508; ramen mélangé : </b> {{ $rmn_today }}<br></p>
			<p><b>&#9889; udon coupe : </b>{{ $udon_today }}</p>
		</p>
	</div>
	@endif
<!--テスト　デバック-->
	</div>
</div>
@endsection

@extends('layouts.footer')