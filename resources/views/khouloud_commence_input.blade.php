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
			$text_etc = "➡ Rappelez-vous au légumerie si nous avons la commandé sur Whatsapp : TEL: 29 105 294";
		@endphp

		<!-- サト上書き -->
		@if(Session::has('sato_record_override'))
			<div>
				<p>&#x1f538;<br> {!! Session::get('sato_record_override')->override_tx_1 !!} </p>
				<p>{{ $text_etc }}</p>
			</div>
		@else 
			<div>
				<!-- カレーを作るかどうか PlanProductionテーブル (id=8) -->
				@if(Session::get('curry') == '1')
					&#x1f35b;  Veuillez préparer le curry ce matin
				@else
					&#x1f538;  <span style="color: red;">Ne pas</span> faire le curry ce matin alors nettoyez-vous l'hôte avec aicha
				@endif
				<!-- 掃除プラン -->
				@if(Session::get('daysoftheweek') == 'tue')
					<p> &#x1f529; Plan de nettoyage:  table au milieu de la cuisine _ khouloud (après 15h)</p>
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
    <td>pièces</td>
			</tr>

			<tr>
				<td>tomate</td>
				<td>
					<select class="form-select" id="tomate" name="tomate" required>
						@foreach ($tomate as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('tomate_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>onion</td>
				<td>
					<select class="form-select" id="onion" name="onion" required>
						@foreach ($onion as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('onion_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>carottes</td>
				<td>
					<select class="form-select" id="carottes" name="carottes" required>
						@foreach ($carottes as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('carottes_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>piment doux</td>
				<td>
					<select class="form-select" id="piment" name="piment" required>
						@foreach ($piment as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('piment_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>aubergine</td>
				<td>
					<select class="form-select" id="aubergine" name="aubergine" required>
						@foreach ($aubergine as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('aubergine_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>courgette</td>
				<td>
					<select class="form-select" id="courgette" name="courgette" required>
						@foreach ($courgette as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('courgette_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
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
				<td>poireaux</td>
				<td>
					<select class="form-select" id="poireaux" name="poireaux" required>
						@foreach ($poireaux as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('poireaux_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>persil</td>
				<td>
					<select class="form-select" id="persil" name="persil" required>
						@foreach ($persil as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('persil_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>coreandre</td>
				<td>
					<select class="form-select" id="coreandre" name="coreandre" required>
						@foreach ($coreandre as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('coreandre_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>laitue</td>
				<td>
					<select class="form-select" id="laitue" name="laitue" required>
						@foreach ($laitue as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('laitue_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>

			<tr>
				<td>choux</td>
				<td>
					<select class="form-select" id="choux" name="choux" required>
						@foreach ($choux as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('choux_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
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
			<tr>
				<td>citron</td>
				<td>
					<select class="form-select" id="citron" name="citron" required>
						@foreach ($citron as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('citron_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
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

	@if(!empty($stock_accessoire))
	<div class="table-responsive" id="records" style="width: 100%;">
	&#11093; accessoiresテーブル
	<table class="table table-striped" style="min-width: 800px;">
		<thead>
			<tr>			
				@foreach ($columns as $column)
					@if ($column === 'created_at')
						<th>Date</th>
					@elseif ($column === 'tahina_pate_du_sesame')
						<th>tahina</th>
					@elseif ($column === 'viande_hachee_poulet_congele')
					<th>hachée poulet congelé</th>
					@elseif ($column === 'viande_hachee_boeuf_congele')
					<th>hachée boeuf congelé</th>
					@elseif ($column === 'tahina_pate_du_sesame')
						<th>tahina</th>
					@else
						<th>{{ $column }}</th>
					@endif					
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($stock_accessoire as $accessoire)
				<tr>
					@foreach ($columns as $column)
					<td>
						@if($column === 'papier_toilettes')
							@php
								$id = $accessoire->$column;
								$matchingName = $papier_toilettes->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'papier_serviette')
							@php
								$id = $accessoire->$column;
								$matchingName = $papier_serviette->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'sac_petit')
							@php
								$id = $accessoire->$column;
								$matchingName = $sac_petit->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'sac_grand')
							@php
								$id = $accessoire->$column;
								$matchingName = $sac_grand->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'sac_poubelle')
							@php
								$id = $accessoire->$column;
								$matchingName = $sac_poubelle->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'tantan_boeuf')
							@php
								$id = $accessoire->$column;
								$matchingName = $tantan->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}

						@else
							<!-- プルダウン以外 -->
							{{ $accessoire->$column }}
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