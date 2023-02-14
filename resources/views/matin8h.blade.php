@extends('layouts.app')
@include('layouts.head')
<!-- パンくずリスト -->
@section('bread_name','8h matin')
@section('content')
<h4>Bonjour Chantal ! &#128536;</h4>
<div class="row gx-3">
    <div class="col-md-12 center-block">
	<form action="task8h" method="post">
	@csrf
        <p style='padding:10px;'>
		 Combien d'udon dans le frigo? <br>
		 <input style="margin-right:5px;" type="number" id="rest_udn" name="rest_udn" min="0" max="25" value="{{ Session::get('rest_udn') }}" required>
		 <input type="submit" value="suivant" class="btn btn-primary btn-round">
		 <input type="hidden" name="actual_page_id" id="actual_page_id" value="matin8h_page1">
		 </p>
	 </form>
    </div>
</div><!--インライングリッド row end -->

@if(Request::is('task8h'))
<!--task8hのページのみ表示  -->
	@if ($sato_instruction)
	{{-- サト指示があった場合 --}}
		<!--サト指示があった場合のみ表示-->
		<div class="row gx-3">
			<div class="col-md-12 center-block">
				<p>
					<b>&#x1f308;</b> <br>{!! $sato_instruction['override_tx_1'] !!}			
				</p>
			</div>
		</div><!--インライングリッド row end-->
		<!--サト指示があった場合のみ表示 end-->
	@else
	{{-- 通常指示 --}}
		<!--今日の指示 （Ramen / Udon）-->
		<div class="row gx-3">
			<div class="col-md-12 center-block">
				<p><b>&#129508; ramen mélangé : </b> {{ $rmn_today }}</p>
				<p><b>&#9889; udon coupe : </b>{{ $udon_today }}</p>
			</div>
		</div><!--今日の指示 （Ramen / Udon）end-->
	@endif
@endif

<!--テスト　デバック-->

@endsection

@section('footer')
@endsection