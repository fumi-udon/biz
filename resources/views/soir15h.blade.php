@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<h4>Bonsoir Chantal ! 15H</h4>

<div class="row gx-3">
    <div class="col-md-12 center-block">
		@if( Session::has('sato_record') )			
			<div class="alert alert-primary" role="alert">
				<b>&#3889;<br> {!! Session::get('sato_record')->override_tx_1 !!} </b>
			</div>	
		@elseif ( Session::has('stock_record') )
		<p>
			<b>&#9889; Udon pour le soir:  {{ $result }}</b><br>
		</p>
		@else
		<div class="alert alert-danger" role="alert">
			Les données ne sont pas prêtes Rappellez Aicha pour enregistrer le reste de Udons <br> TEL: 24986077
		</div>
		@endif
    </div>
</div><!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')