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
			<p>{!! session('flash_message') !!}</p>	
		</div>
	</div>
	@endif
    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
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
			<tr>
				<td>essuie jumbo</td>
				<td><input type="number" id="essuie_jmb" name="essuie_jmb" class="form-control"></td>
				<td>pieces</td>
			</tr>
			<tr>
				<td>papier toilettes</td>
				<td><input type="number" id="papier_toilettes" name="papier_toilettes" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique chaud 750ml</td>
				<td><input type="number" id="plastique_chaud_750ml" name="plastique_chaud_750ml" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique froide 500ml</td>
				<td><input type="number" id="plastique_froide_500ml" name="plastique_froide_500ml" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>plastique froide 1000ml</td>
				<td><input type="number" id="plastique_froide_1000ml" name="plastique_froide_1000ml" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Papier serviette pour les clients</td>
				<td><input type="number" id="papier_serviette" name="papier_serviette" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Barquettes aluminium 901</td>
				<td><input type="number" id="aluminium_901" name="aluminium_901" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Barquettes aluminium 701</td>
				<td><input type="number" id="aluminium_701" name="aluminium_701" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Barquettes aluminium 401</td>
				<td><input type="number" id="aluminium_401" name="aluminium_401" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>Pot de sauce 30cc</td>
				<td><input type="number" id="pot_de_sauce_30cc" name="pot_de_sauce_30cc" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>bol carton rond</td>
				<td><input type="number" id="bol_carton_rond" name="bol_carton_rond" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>sac transparant</td>
				<td><input type="number" id="sac_transparant" name="sac_transparant" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>sac petit</td>
				<td><input type="number" id="sac_petit" name="sac_petit" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>sac grand</td>
				<td><input type="number" id="sac_grand" name="sac_grand" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>sac poubelle</td>
				<td><input type="number" id="sac_poubelle" name="sac_poubelle" class="form-control"></td>
				<td>paquet</td>
			</tr>
			<tr>
				<td>bicarbonate</td>
				<td><input type="number" id="bicarbonate" name="bicarbonate" class="form-control"></td>
				<td>boite</td>
			</tr>
			<tr>
				<td>tahina pâte du sésame</td>
				<td><input type="number" id="tahina_pate_du_sesame" name="tahina_pate_du_sesame" class="form-control"></td>
				<td>pieces</td>
			</tr>
			<tr>
				<td>viande hachée de poulet en congelé (bureau)</td>
				<td><input type="number" id="viande_hachee_poulet_congele" name="viande_hachee_poulet_congele" class="form-control"></td>
				<td>sachet</td>
			</tr>
			<tr>
				<td>viande hachée de boeuf en congelé (bureau)</td>
				<td><input type="number" id="viande_hachee_boeuf_congele" name="viande_hachee_boeuf_congele" class="form-control"></td>
				<td>sachet</td>
			</tr>
			<tr>
				<td>tantan boeuf (bureau)</td>
				<td><input type="number" id="tantan_boeuf" name="tantan_boeuf" class="form-control"></td>
				<td>pieces</td>
			</tr>
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
	<div class="container mt-5">
		<a href="/jesser_top" class="text-primary">Retour</a>
	</div>
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')