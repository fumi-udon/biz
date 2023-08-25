@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h4 mb-0 text-white lh-1"><b>Préparation pour le diner</b></h1>
		<small></small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded">
	<div class="row gx-3">
    @php
        $text_etc = "➡ Si c'est peu : oeuf, chips, namuru, pudding, salade, légumes etc... ";
    @endphp
	@if(Session::has('sato_record') && !empty($sato_text_mode) && $sato_text_mode == 6)
		<div class="alert alert-primary border" role="alert">
			<b>&#3889;<br> {!! Session::get('sato_record')->override_tx_1 !!} </b>
			<p>{{ $text_etc }}</p>
		</div>
	@elseif ( isset($stock_ingredient) )
		<div>
			<p><h5>Aicha</h5></p>
			<!-- サト追加情報 -->
			<p>
				@if(!empty($sato_record_aicha))
						&#11093; {!! $sato_record_aicha->override_tx_1 !!}
				@endif
			</p>
			<p>&#127837; Udon: 4 </p>
			<p>
				&#129379; Bouillons:
				<!-- 週末 金/土 -->
				@if($daysoftheweek == 'fri' || $daysoftheweek == 'sat')
					{{ 8 - $aicha_bouillons }} L
				@else
				<!-- 平日 -->
					{{ 7 - $aicha_bouillons }} L
				@endif
				
			</p>
			<hr>
			<!-- アンドレア -->
			<p><h5>Andrea</h5></p>
			<!-- サト追加情報 -->
			<p>
				@if(!empty($sato_record_andrea))
						&#11093; {!! $sato_record_andrea->override_tx_1 !!}
				@endif
			</p>
			<p>
				&#127833; RIZ:
				@if($aicha_riz == 0 || $aicha_riz == 1)
					14 portions
				@elseif($aicha_riz == 2)
					12 portions
				@elseif($aicha_riz == 3)
					9 portions
				@elseif($aicha_riz == 4)
					8 portions
				@elseif($aicha_riz == 5)
					5 portions
				@elseif($aicha_riz == 6)
					4 portions
				@elseif($aicha_riz == 7)
						non
				@endif
			</p>
		</div>
		<p>
			{{ $text_etc }}
		</p>
	@else
		@if (!Request::is('addnote_diner'))
		<div class="alert alert-danger" role="alert">
			Les données ne sont pas prêtes Rappellez Aicha pour se remseigner
		</div>
		@endif
	@endif
	</div>
	        <!--aicha_works_topに戻るリンク-->
			<div class="container mt-5">
            <a href="/aicha_works_top" class="text-primary">Retour</a>
        	</div>
</div>
	<div style="text-align: right;">
			<p class="m-2 small"><a href="/addnote_diner_page" id="note_open" style="color: grey;">指示追加</a></p>
	</div>
</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>