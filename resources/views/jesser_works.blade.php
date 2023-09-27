@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h5 mb-0 text-white lh-1"><b>work's for Jesser</b></h1>
		<small></small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded">
	<div class="row gx-3">

		<div class="" role="">
		<p><h5>Bonjour Jesser!</h5></p>
		@php
			$text_etc = "";
		@endphp

		<!-- サト上書き -->
		@if(Session::has('sato_record_override'))
			<div>
				<p>&#x1f538;<br> {!! Session::get('sato_record_override')->override_tx_1 !!} </p>
				<p>{{ $text_etc }}</p>
			</div>
		@else 
			<div>
				<!-- 月曜：  プラン -->
				@if($daysoftheweek == 'mon')
					<p> &#x1f5c3; Achats: demandez un list à Sato</p>
				@endif
				<!-- 火曜： プラン -->
				@if($daysoftheweek == 'tue')
					<p> &#x1f5c3; Ménage de salle client: l'étagère et le comptoir et des points sals</p>
					<p> &#x1f5c3; Achats: demandez un list à Sato</p>
				@endif
				<!-- 水曜 プラン -->
				@if($daysoftheweek == 'wed')
					<p> &#x1f5c3; Vérifier le stock de boissons et de thé et passer les commandes nécessaires.</p>
					<p> &#x1f5c3; Achats: demandez un list à Sato</p>
				@endif
				<!-- 木曜  プラン -->
				@if($daysoftheweek == 'thu')
					<p> &#x1f5c3; Achats: demandez un list à Sato</p>
					<p> &#x1f5c3; Ménage de salle client: l'étagère et le comptoir et des points sals</p>
				@endif
				<!-- 金曜  プラン -->
				@if($daysoftheweek == 'fri')
					<p> &#x1f5c3; Achats: demandez un list à Sato</p>
				@endif

				<!-- ↓ 不定期対応 ↓ -->
 				<!-- STEG SONET -->
				@if( $effect_dates['steg_sonet'] == $date_ymd )
					<p> &#x1f6ce; STEG et SONET etc... :  veuillez les payer cette semaine. N'oubliez pas apporter des photos de deux compteur</p>
				@endif				
				<!-- chéques　月1 -->
				@if( $effect_dates['cheque_1'] == $date_ymd )
					<p> &#x1f5c3; Si vous avez des chèques à encaisser, veuillez les déposer à la banque Attijari avant le vendredi</p>
				@endif
				<!-- 在庫管理 -->
				@if( $effect_dates['stock_asia_1'] == $date_ymd 
						|| $effect_dates['stock_asia_2']  == $date_ymd 
						|| $effect_dates['stock_emballage_1']  == $date_ymd 
						|| $effect_dates['stock_boeuf_1'] == $date_ymd 
						|| $effect_dates['stock_boeuf_2'] == $date_ymd 
					)
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
				@endif				

			</div>
			<!-- サト追加 -->
			@if(Session::has('sato_record_add'))
			<div>
				<p> &#x1f538; {!! Session::get('sato_record_add')->override_tx_1 !!} </p>				
			</div>			
			@endif
			<p class="p-3">{{ $text_etc }}</p>
		@endif
		</div>
	        <!--works_topに戻るリンク-->
			<div class="container mt-5">
            <a href="/jesser_top" class="text-primary">Retour</a>
        	</div>
		@php
			$flg_oride = 13;
			$flg_add = 14;
			$actionMessage = 'Jesser works 用';
		@endphp
    	<p class="m-2 small" style ="padding:50px;">
			<a href="{{ route('common.addnote', ['flg_oride' => $flg_oride,'flg_add' => $flg_add, 'actionMessage' => $actionMessage]) }}" style="color: grey;">
				指示追加 
			</a>
   		</p>
</div>

</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>