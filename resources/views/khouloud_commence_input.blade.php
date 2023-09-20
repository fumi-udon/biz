@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Khouloud work's</h1>
		<small>task information</small>
	</div>
	</div>
	@if (Session::has('method_name') && Session::get('method_name') == 'store')
		<div class="alert alert-primary border" role="alert">
		<p><h5>Bonjour Khouloud!</h5></p>
		@php
			$text_etc = "➡ Rappelez-vous au légumerie si nous avons la commandé sur Whatsapp : TEL: 29 105 294  (Aziz livreur)";
			$text_ref_01 = "";
		@endphp

		<!-- サト上書き -->
		@if(Session::has('sato_record_override'))
			<div>
				<p>&#x1f538;<br> {!! Session::get('sato_record_override')->override_tx_1 !!} </p>
				<p>{{ $text_etc }}</p>
			</div>
		@else 
			<div class="">
				<!-- カレーを作るかどうか PlanProductionテーブル (id=8) -->
				@if(Session::get('curry') == '1')
					<p>&#x1f35b;  Veuillez préparer le curry ce matin</p>
				@else
				<p>&#x1f538;  <span style="color: red;">Ne pas</span> faire le curry ce matin alors nettoyez-vous l'hôte avec aicha</p>
				@endif
				<!-- 掃除プラン -->
				@if(Session::get('daysoftheweek') == 'tue')
					<p> &#x1f529; Plan de nettoyage:  table au milieu de la cuisine _ khouloud (après 15h)</p>
				@endif

				<!-- おにぎりの鬼 -->
				@if(Session::get('daysoftheweek') == 'fri' || Session::get('daysoftheweek') == 'mon')
					<p> &#x2605; Onigiri (140g)  2 pièces </p>
				@elseif(Session::get('daysoftheweek') == 'sat')
					<p> &#x2605; Onigiri (140g)  4 pièces </p>
				@endif

				<!-- お好み焼き KIT　きっと役に立つ  -->
				@if( Session::get('okonomiyaki_now') == 0 )
				<p> &#x1f365; Paquet pour l'okonomiyaki(farine et du poudre, choux2, chips)   1 paquet</p>
				@endif

				<!-- ボトル満タンが気持ちえーー  -->
				<p> &#x1f376; Remplir des bouteilles : mayonnaise / moutard / nori émincées</p>

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
	@endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
		<form method='POST' action="{{ route('khouloud.commence.store',['page_id' => 'khouloud_commence_input','shop' => 'bistronippon']) }}">
		@csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 50%;">Article</th>
                    <th>Quantité</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
			<tr>
    <td>pâte du curry</td>
    <td>
        <select class="form-select" id="patecurry" name="patecurry" required>
            @foreach ($patecurry as $item)
                <option value="{{ $item['id'] }}" @if( Session::get('patecurry_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
            @endforeach
        </select>
    </td>
    <td></td>
			</tr>
			<tr>
				<td>pomme du terre</td>
				<td>
					<select class="form-select" id="pomme_de_terre" name="pomme_de_terre" required>
						@foreach ($pomme_de_terre as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('pomme_de_terre_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>
			<tr>
				<td>apple (pomme)</td>
				<td>
					<select class="form-select" id="apple" name="apple" required>
						@foreach ($apple as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('apple_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<!-- okonomiyaki -->
			<tr>
				<td>okonomiyaki</td>
				<td><input type="number" id="bn1" name="bn1" class="form-control" value="{{ Session::get('okonomiyaki_now') }}" required></td>
				<td>paquet</td>
			</tr>

            </tbody>
        </table>
		<div class="row p-2">
				<div class="col-md-12">
					<input type="submit" value="envoyer" name="btn_khouloud_commence" id='btn_khouloud_commence' class="btn btn-primary btn-round">
				</div>
		</div><!--row end-->
		</form>
	  </div><!--コンテナー end -->
    </div>
	<!--戻るリンク-->
	<div class="container mt-5">
		<a href="/jesser_top" class="text-primary">Retour</a>
	</div>

@php
$flg_oride = 11;
$flg_add = 12;
$actionMessage = 'Khouloud用';
@endphp
    <p class="m-2 small" style ="padding:50px;">
        <a href="{{ route('common.addnote', ['flg_oride' => $flg_oride,'flg_add' => $flg_add, 'actionMessage' => $actionMessage]) }}" style="color: grey;">
            指示追加 
        </a>
    </p>

	@if(!empty($stock_cuisine_main))
	<div class="table-responsive" id="records" style="width: 100%;">
	&#11093; StockMain
	<table class="table table-striped" style="min-width: 800px;">
		<thead>
			<tr>			
				@foreach ($columns as $column)
					@if($column === 'bn1')
					<th>Okonomiyaki</th>
					@else
					<th>{{ $column }}</th>
					@endif		
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($stock_cuisine_main as $record)
				<tr>
					@foreach ($columns as $column)
					<td>
						@if($column === 'patecurry')
							@php
								$id = $record->$column;
								$matchingName = $patecurry->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'pomme_de_terre')
							@php
								$id = $record->$column;
								$matchingName = $pomme_de_terre->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'apple')
							@php
								$id = $record->$column;
								$matchingName = $apple->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@else
							<!-- プルダウン以外 -->
							{{ $record->$column }}
						@endif
					</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	@endif

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>