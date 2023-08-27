@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h4 mb-0 text-white lh-1"><b>Kitchen work's for diner</b></h1>
		<small></small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded">
	<div class="row gx-3">
    @php
        $text_etc = "➡ ";
    @endphp
	@if(Session::has('sato_record') && !empty($sato_text_mode) && $sato_text_mode == 9)
		<div class="alert alert-primary border" role="alert">
			<b>&#3889;<br> {!! Session::get('sato_record')->override_tx_1 !!} </b>
			<p>{{ $text_etc }}</p>
		</div>
	@elseif ( isset($stock_ingredients) )
		<div>
			<p><h5><u>Mise en place pour le diner</u></h5></p>
			<!-- サト追加情報 -->
			<p>
				@if(!empty($sato_record))
						&#11093; {!! $sato_record->override_tx_1 !!}
				@endif
			</p>
			<p> &#127833; Onigiri 4 pièces (total)</p>
			<p> &#129367; Salade 1 grand bol (total)</p>
			<p> &#129367; Salade 1 petit bol (total)</p>
			<p> &#129382; Placer les choux en bas le comptoir</p>

			@if($req_omlettes < 1)
			<p>
				&#127833; omlettes pour mazé: préparer 1 p
			</p>
			@endif

			@if($req_fms < 5)
			<p>
				&#127744; fruits de mer: 
				@if($req_fms == 0)
					préparer 5 p 
				@elseif($req_fms == 1)
					préparer 4 p
				@elseif($req_fms == 2)
					préparer 3 p
				@elseif($req_fms == 3)
					préparer 2 p
				@elseif($req_fms == 4)
					préparer 1 p
				@endif	
			</p>
			@endif

			@if($req_laitues < 3)
			<p>
			&#127744; laitue: remplir une boite				
			</p>
			@endif

			@if($req_okonomiyakis < 1)
			<p>
			&#127744; okonomiyaki: préparer 1 p			
			</p>
			@endif
			<hr>
			<p><h6><u>Vérification et mise en place</u></h6></p>
			<p>
				<ul class=“list-group”> 
					<li class=“list-group-item”>laitue (remplir)</li> 
					<li class=“list-group-item”>salades (tmt/carottes/concombre)</li> 
					<li class=“list-group-item”>citron</li> 
					<li class=“list-group-item”>onion en julienne</li> 
					<li class=“list-group-item”>moutarde</li> 
					<li class=“list-group-item”>mayonnaise</li> 
					<li class=“list-group-item”>cha-shu</li> 
					<li class=“list-group-item”>choux émincée</li> 
					<li class=“list-group-item”> légumes émincée</li> 
				</ul>
			</p>
		</div>
		<p class="my-3 p-3">
			{{ $text_etc }}
		</p>

	</div>
	@endif
	        <!--aicha_works_topに戻るリンク-->
			<div class="container mt-5">
            <a href="/cuisine_diner_top" class="text-primary">Retour</a>
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