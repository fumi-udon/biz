@extends('layouts.app')
<!-- パンくずリスト -->
@extends('layouts.head')
@section('content')
<main class="container">
	<div class="mt-5">
		<h3 style="padding-bottom:25px;">Contact d'urgence</h3>

		<div class="mb-4">
			<h5>Problème d'installation (設備不良)</h5>
			<ul class="list-group">
				<li class="list-group-item">Samir éléctrique (電気) - 52 885 905</li>
				<li class="list-group-item">Plombier Taher （ガス・水回り） - 20 103 779</li>
				<li class="list-group-item">Plombier kamel （ガス・水回り） - 97 513 087</li>
			</ul>
		</div>

		<div class="mb-4">
			<h5>urgence (緊急)</h5>
			<ul class="list-group">
				<li class="list-group-item">Thaer gardian - 21 444 282</li>
				<li class="list-group-item">Younesse - 21 005 963</li>
				<li class="list-group-item">Atef (comptable) - 21 419 240</li>
				<li class="list-group-item">Mme. foulla （大家） - 93 240 176</li>
			</ul>
		</div>

	</div>
</main>
@endsection

@extends('layouts.footer')