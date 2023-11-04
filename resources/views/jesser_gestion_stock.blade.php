@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">jesser_gestion_stock</h1>
		<small>check stock data</small>
	</div>
	</div>

	@if (Session::has('flash_message'))
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-success" role="alert">
			<p>&#x1f618; Nous vous remercions. Les données d'entrée ont été enregistrées avec succès.</p>	
		</div>
	</div>
	@endif

    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
		<h4>Organiser les marchandises et les compter</h4>
		<form method='POST' action="{{ route('jesser.gestion.stock.store',['id' => 'stock_emballage','params' => 'bistronippon']) }}">
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
<!-- ストック管理 リスト（曜日毎に） start -->

<!-- Emballage系統 -->
@if ( $effect_dates['stock_emballage_1'] == $date_ymd || $effect_dates['stock_emballage_2'] == $date_ymd )
			<tr>
				<td>essuie jumbo</td>
				<td><input type="number" id="essuie_jmb" name="essuie_jmb" class="form-control" value="{{ Session::get('essuie_jmb') }}" required></td>
				<td>pieces</td>
			</tr>
			<tr>
				<td>papier toilettes</td>
				<td>
					<select class="form-select" id="papier_toilettes" name="papier_toilettes" required>
						@foreach ($papier_toilettes as $papier_toilette)
							<option value="{{ $papier_toilette['id'] }}" @if( Session::get('papier_toilettes_now')  == $papier_toilette['id'] ) selected @endif> {{ $papier_toilette['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique froide 500ml</td>
				<!-- <td><input type="number" id="plastique_froide_500ml" name="plastique_froide_500ml" class="form-control" value="{{ Session::get('plastique_froide_500ml') }}" required></td> -->
				<td>
					<select class="form-select" id="plastique_froide_500ml" name="plastique_froide_500ml" required>
						@foreach ($plastique_froide_500ml as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('plastique_froide_500ml_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique chaud 750ml</td>
				<!-- <td><input type="number" id="plastique_chaud_750ml" name="plastique_chaud_750ml" class="form-control" value="{{ Session::get('plastique_chaud_750ml') }}" required></td> -->
				<td>
					<select class="form-select" id="plastique_chaud_750ml" name="plastique_chaud_750ml" required>
						@foreach ($plastique_chaud_750ml as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('plastique_chaud_750ml_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique froide 1000ml</td>
				<!-- <td><input type="number" id="plastique_froide_1000ml" name="plastique_froide_1000ml" class="form-control" value="{{ Session::get('plastique_froide_1000ml') }}" required></td> -->
				<td>
					<select class="form-select" id="plastique_froide_1000ml" name="plastique_froide_1000ml" required>
						@foreach ($plastique_froide_1000ml as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('plastique_froide_1000ml_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Papier serviette pour les clients</td>
				<td>
					<select class="form-select" id="papier_serviette" name="papier_serviette" required>
						@foreach ($papier_serviette as $papier_serv)
							<option value="{{ $papier_serv['id'] }}" @if( Session::get('papier_serviette_now')  == $papier_serv['id'] ) selected @endif> {{ $papier_serv['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Barquettes aluminium S</td>
				<!-- <td><input type="number" id="aluminium_401" name="aluminium_401" class="form-control" value="{{ Session::get('aluminium_401') }}" required></td> -->
				<td>
					<select class="form-select" id="aluminium_401" name="aluminium_401" required>
						@foreach ($aluminium_401 as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('aluminium_401_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>			
				<td>paquet</td>
			</tr>
			<tr>
				<td>Barquettes aluminium M</td>
				<!-- <td><input type="number" id="aluminium_701" name="aluminium_701" class="form-control" value="{{ Session::get('aluminium_701') }}" required></td> -->
				<td>
					<select class="form-select" id="aluminium_701" name="aluminium_701" required>
						@foreach ($aluminium_701 as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('aluminium_701_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Barquettes aluminium L</td>
				<!-- <td><input type="number" id="aluminium_901" name="aluminium_901" class="form-control" value="{{ Session::get('aluminium_901') }}" required></td> -->
				<td>
					<select class="form-select" id="aluminium_901" name="aluminium_901" required>
						@foreach ($aluminium_901 as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('aluminium_901_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>

			<tr>
				<td>Pot de sauce 30cc</td>
				<!-- <td><input type="number" id="pot_de_sauce_30cc" name="pot_de_sauce_30cc" class="form-control" value="{{ Session::get('pot_de_sauce_30cc') }}" required></td> -->
				<td>
					<select class="form-select" id="pot_de_sauce_30cc" name="pot_de_sauce_30cc" required>
						@foreach ($pot_de_sauce_30cc as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('pot_de_sauce_30cc_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>			
				<td>paquet</td>
			</tr>
			<tr>
				<td>bol carton rond</td>
				<!-- <td><input type="number" id="bol_carton_rond" name="bol_carton_rond" class="form-control"  value="{{ Session::get('bol_carton_rond') }}" required></td> -->
				<td>
					<select class="form-select" id="bol_carton_rond" name="bol_carton_rond" required>
						@foreach ($bol_carton_rond as $elem)
							<option value="{{ $elem['id'] }}" @if( Session::get('bol_carton_rond_now')  == $elem['id'] ) selected @endif> {{ $elem['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>pochette en papier</td>
				<!-- 対応テーブルカラム名：article1 -->
				<td>
					<select class="form-select" id="pochette_en_papier" name="pochette_en_papier" required>
						@foreach ($pochette_en_papier as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('pochette_en_papier_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>
			<tr>
				<td>sac en papier L</td>
				<!-- 対応テーブルカラム名：article2 -->
				<td>
					<select class="form-select" id="sac_en_papier_L" name="sac_en_papier_L" required>
						@foreach ($sac_en_papier_L as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('sac_en_papier_L_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>pièces</td>
			</tr>
			<tr>
				<td>sac transparant</td>
				<!-- <td><input type="number" id="sac_transparant" name="sac_transparant" class="form-control" value="{{ Session::get('sac_transparant') }}" required></td> -->
				<td>
					<select class="form-select" id="sac_transparant" name="sac_transparant" required>
						@foreach ($sac_transparant as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('sac_transparant_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>sac petit poignet</td>
				<td>
					<select class="form-select" id="sac_petit" name="sac_petit" required>
						@foreach ($sac_petit as $item)
							<option value="{{ $item['id'] }}" @if( Session::get('sac_petit_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>sac grand poignet</td>
				<td>
				<select class="form-select" id="sac_grand" name="sac_grand" required>
					@foreach ($sac_grand as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('sac_grand_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
					@endforeach
				</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>sac poubelle</td>
				<td>
				<select class="form-select" id="sac_poubelle" name="sac_poubelle" required>
					@foreach ($sac_poubelle as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('sac_poubelle_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
					@endforeach
				</select>
				</td>
				<td></td>
			</tr>

<!-- 肉系と重曹とかその辺りのヘンテコ食材-->
@elseif ( $effect_dates['stock_boeuf_1'] == $date_ymd || $effect_dates['stock_boeuf_2'] == $date_ymd )
			<tr>
				<td>viande hachée de poulet en congelé (bureau)</td>
				<td><input type="number" id="viande_hachee_poulet_congele" name="viande_hachee_poulet_congele" class="form-control" value="{{ Session::get('viande_hachee_poulet_congele') }}" required></td>
				<td>sachet</td>
			</tr>
			<tr>
				<td>viande hachée de boeuf en congelé (bureau)</td>
				<td><input type="number" id="viande_hachee_boeuf_congele" name="viande_hachee_boeuf_congele" class="form-control" value="{{ Session::get('viande_hachee_boeuf_congele') }}" required></td>
				<td>sachet</td>
			</tr>
			<tr>
				<td>tantan boeuf (bureau)</td>
				<td>
				<select class="form-select" id="tantan_boeuf" name="tantan_boeuf" required>
					@foreach ($tantan as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('tantan_boeuf_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
					@endforeach
				</select>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>bicarbonate</td>
				<td><input type="number" id="bicarbonate" name="bicarbonate" class="form-control" value="{{ Session::get('bicarbonate') }}" required></td>
				<td>paquets</td>
			</tr>
			<tr>
				<td>tahina pâte du sésame</td>
				<td><input type="number" id="tahina_pate_du_sesame" name="tahina_pate_du_sesame" class="form-control" value="{{ Session::get('tahina_pate_du_sesame') }}" required></td>
				<td>pieces</td>
			</tr>
<!-- アジア食材系のやーーつぅー -->
@elseif ( $effect_dates['stock_asia_1'] == $date_ymd || $effect_dates['stock_asia_2'] == $date_ymd )
			<!-- sauce_poisson -->
			<tr>
				<td>sauce_poisson</td>
				<td><input type="number" id="sauce_poisson" name="sauce_poisson" class="form-control" value="{{ Session::get('sauce_poisson') }}" required></td>
				<td>bouteilles</td>
			</tr>

			<!-- pate_miso_20kg -->
			<tr>
				<td>pate_miso_20kg</td>
				<td>
					<select class="form-select" id="pate_miso_20kg" name="pate_miso_20kg" required>
						@foreach ($pate_miso_20kg as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('pate_miso_20kg_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td> bidon</td>
			</tr>

			<!-- mirin_20kg -->
			<tr>
				<td>mirin_20kg</td>
				<td>
					<select class="form-select" id="mirin_20kg" name="mirin_20kg" required>
						@foreach ($mirin_20kg as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('mirin_20kg_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td> bidon</td>
			</tr>

			<!-- algue_nori -->
			<tr>
				<td>algue_nori</td>
				<td><input type="number" id="algue_nori" name="algue_nori" class="form-control" value="{{ Session::get('algue_nori') }}" required></td>
				<td>sachet</td>
			</tr>

			<!-- algue_wakame -->
			<tr>
				<td>algue_wakame</td>
				<td>
					<select class="form-select" id="algue_wakame" name="algue_wakame" required>
						@foreach ($algue_wakame as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('algue_wakame_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td> paquet</td>
			</tr>

			<!-- gari_gingimbre -->
			<tr>
				<td>gari_gingimbre</td>
				<td><input type="number" id="gari_gingimbre" name="gari_gingimbre" class="form-control" value="{{ Session::get('gari_gingimbre') }}" required></td>
				<td>sachet</td>
			</tr>

			<!-- poudre_dashi -->
			<tr>
				<td>poudre_dashi (combien de kg?)</td>
				<td><input type="number" id="poudre_dashi" name="poudre_dashi" class="form-control" value="{{ Session::get('poudre_dashi') }}" required></td>
				<td>kg</td>
			</tr>

			<!-- shichimi -->
			<tr>
				<td>shichimi (nanami spicy)</td>
				<td>
					<select class="form-select" id="shichimi" name="shichimi" required>
						@foreach ($shichimi as $item)
						<option value="{{ $item['id'] }}" @if( Session::get('shichimi_now')  == $item['id'] ) selected @endif> {{ $item['name'] }} </option>
						@endforeach
					</select>
				</td>
				<td> paquet</td>
			</tr>

			<!-- sauce_tomyum -->
			<tr>
				<td>sauce_tomyum</td>
				<td><input type="number" id="sauce_tomyum" name="sauce_tomyum" class="form-control" value="{{ Session::get('sauce_tomyum') }}" required></td>
				<td>pièces</td>
			</tr>

			<!-- sauce_toubanjyun -->
			<tr>
				<td>sauce_toubanjyun (kg)</td>
				<td><input type="number" id="sauce_toubanjyun" name="sauce_toubanjyun" class="form-control" value="{{ Session::get('sauce_toubanjyun') }}" required></td>
				<td>kg</td>
			</tr>
@else

			<p class="text-danger text-uppercase p-5">Nothing for today</p>

@endif
<!-- ストック管理 リスト（曜日毎に） end -->

            </tbody>
        </table>
		<div class="row p-2">
				<div class="col-md-12">
					<input type="submit" value="envoyer" name="btn_jsser_stocks" id='btn_jsser_stocks' class="btn btn-primary btn-round">
				</div>
		</div><!--row end-->
		</form>
	  </div><!--コンテナー end -->
    </div>
	<!--戻るリンク-->
	<div class="container mt-5  p-3">
		<a href="/jesser_top" class="text-primary">Retour</a>
	</div>

	@if(!empty($stock_accessoire))
	<div class="table-responsive" id="records" style="width: 100%;">
	<table class="table table-striped" style="min-width: 800px;">
		<thead>
			<tr>			
				@foreach ($columns as $column)
					@if ($column === 'created_at')
						<th>Date</th>
				<!-- Emballage -->
					@elseif ($column === 'aluminium_401')
						<th>aluminium S</th>
					@elseif ($column === 'aluminium_701')
						<th>aluminium M</th>
					@elseif ($column === 'aluminium_901')
						<th>aluminium L</th>
					@elseif ($column === 'pot_de_sauce_30cc')
						<th>pot 30cc</th>
					@elseif ($column === 'bol_carton_rond')
						<th>bol carton rond</th>
					@elseif ($column === 'article1')
					<th>pochette en papier</th>
					@elseif ($column === 'article2')
					<th>sac en papier L</th>
						
				<!-- 肉系 -->
					@elseif ($column === 'tahina_pate_du_sesame')
						<th>tahina</th>
					@elseif ($column === 'viande_hachee_poulet_congele')
					<th>hachée poulet congelé</th>
					@elseif ($column === 'viande_hachee_boeuf_congele')
					<th>hachée boeuf congelé</th>
				<!-- asia and 食材 -->
					@elseif ($column === 'tahina_pate_du_sesame')
						<th>tahina</th>					
					@elseif ($column === 'sauce_toubanjyun')
						<th>Tobanjyuan(kg)</th>
					@elseif ($column === 'poudre_dashi')
					<th>Dashi (kg)</th>			
					@elseif ($column === 'algue_nori')
					<th>Nori</th>
					@elseif ($column === 'gari_gingimbre')
					<th>Gari</th>
					@elseif ($column === 'algue_wakame')
					<th>Wakame</th>

				<!-- ELSEそのまま表示 -->
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

						@elseif($column === 'plastique_chaud_750ml')
							@php
								$id = $accessoire->$column;
								$matchingName = $plastique_chaud_750ml->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'plastique_froide_500ml')
							@php
								$id = $accessoire->$column;
								$matchingName = $plastique_froide_500ml->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'plastique_froide_1000ml')
							@php
								$id = $accessoire->$column;
								$matchingName = $plastique_froide_1000ml->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'bol_carton_rond')
							@php
								$id = $accessoire->$column;
								$matchingName = $bol_carton_rond->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'aluminium_401')
							@php
								$id = $accessoire->$column;
								$matchingName = $aluminium_401->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'aluminium_701')
							@php
								$id = $accessoire->$column;
								$matchingName = $aluminium_701->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'aluminium_901')
							@php
								$id = $accessoire->$column;
								$matchingName = $aluminium_901->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'pot_de_sauce_30cc')
							@php
								$id = $accessoire->$column;
								$matchingName = $pot_de_sauce_30cc->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'sac_transparant')
							@php
								$id = $accessoire->$column;
								$matchingName = $sac_transparant->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'article1')<!-- pochette_en_papier -->
							@php
								$id = $accessoire->$column;
								$matchingName = $pochette_en_papier->where('id', $id)->first()['name'] ?? '';
							@endphp
							{{ $matchingName }}
						@elseif($column === 'article2')<!-- sac_en_papier_L -->
							@php
								$id = $accessoire->$column;
								$matchingName = $sac_en_papier_L->where('id', $id)->first()['name'] ?? '';
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