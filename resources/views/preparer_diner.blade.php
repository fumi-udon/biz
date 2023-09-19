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
        $text_etc = "➡ Si c'est peu : oeuf, chips, namuru, pudding etc... ";
		$text_kitchen = "&#x1f5fe; Si c'est peu : <span style='color: red;'>des légumes mixtes émincées et des choux émincées et de la laitue</span> ";
    @endphp
	@if(Session::has('sato_record') && !empty($sato_text_mode) && $sato_text_mode == 6)
		<div class="alert alert-primary border" role="alert">
			<b>&#3889;<br> {!! Session::get('sato_record')->override_tx_1 !!} </b>
			<p>{{ $text_etc }}</p>
		</div>
	@elseif ( isset($stock_ingredient) )
		<div>
			<p><h5>Aicha</h5></p>
			<!-- 追加情報 -->
			<p>
				@if($daysoftheweek == 'wed')
						&#11091; Friteuse et étagère de friteuse et sous la friteuse (responsable: aïcha et fifi (matin ou après 15h))
				@endif
			</p>
			<p>
				@if(!empty($sato_record_aicha))
						&#11093; {!! $sato_record_aicha->override_tx_1 !!}
				@endif
			</p>
			
			<!-- plan_productionテーブル id=6のデータ表示 -->
			<p>&#127837; Udon: {{ $plan_production[$daysoftheweek] }} </p>
			
			@if($aicha_bouillons <= 5)
			<p>
				<!-- 5L以下の場合のみブイヨン作る -->
				&#129379; Bouillons:
				<!-- 週末 金/土 -->
				@if($daysoftheweek == 'fri' || $daysoftheweek == 'sat')
					{{ 8 - $aicha_bouillons }} L
				@else
				<!-- 平日 -->
					{{ 7 - $aicha_bouillons }} L
				@endif
			@endif
			</p>
			@if($daysoftheweek == 'tue' || $daysoftheweek == 'fri')	
			<p>					
				{!! $text_kitchen !!} 
			</p>
			@endif
			<hr>
			<!-- アンドレア -->
			<p><h5>FIFI</h5></p>
			<!-- 追加情報 -->
			<p>
				@if($daysoftheweek == 'fri')
						&#11093; Plan de nettoyage : réfrigérateur Wirpool (intérieur et extérieur)
				@endif
			</p>
			@if(!empty($sato_record_andrea))
			<p>
				&#11094; {!! $sato_record_andrea->override_tx_1 !!}				
			</p>
			@endif
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
			@if($daysoftheweek == 'mon' || $daysoftheweek == 'wed'  || $daysoftheweek == 'thu' || $daysoftheweek == 'sat')	
			<p>					
				{!! $text_kitchen !!}
			</p>
			@endif
		</div>
		<p class="my-3 p-3">
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