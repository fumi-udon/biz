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
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
					<p> &#x1f5c3; Achats: monoprix / Zepyer / des magazins (demandez un list à Sato)</p>
				@endif
				<!-- 火曜： チェック銀行へ プラン -->
				@if($daysoftheweek == 'tue')
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
					<p> &#x1f5c3; Si vous avez des chèques à encaisser, veuillez les déposer à la banque Attijari avant le vendredi</p>
					<p> &#x1f5c3; Achats: monoprix / Zepyer / des magazins (demandez un list à Sato)</p>
				@endif
				<!-- 水曜 チェック銀行へ プラン -->
				@if($daysoftheweek == 'wed')
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
					<p> &#x1f5c3; Vérifier le stock de boissons et de thé et passer les commandes nécessaires.</p>
					<p> &#x1f5c3; Achats: monoprix / Zepyer / des magazins (demandez un list à Sato)</p>
				@endif
				<!-- 木曜  プラン -->
				@if($daysoftheweek == 'thu')
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
					<p> &#x1f5c3; Achats: monoprix / Zepyer / des magazins (demandez un list à Sato)</p>
				@endif
				<!-- 金曜  プラン -->
				@if($daysoftheweek == 'fri')
					<p> &#x1f5c3; Accédez à la page "gestion des stocks".</p>
					<p> &#x1f5c3; Achats: monoprix / Zepyer / des magazins (demandez un list à Sato)</p>
				@endif

				<!-- Steg Sonet 月初め -->
				@if($daysoftheweek == 'mon' && ( $le_date == '01' || $le_date == '02' || $le_date == '03' || $le_date == '04' || $le_date == '05' || $le_date == '06' || $le_date == '07' || $le_date == '08'))
					<p> &#x1f6ce; Si vous n'avez pas encore réglé vos factures STEG/SONET/etc du mois dernier, veuillez les payer cette semaine. N'oubliez pas apporter des photos</p>
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