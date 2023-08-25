@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">


<div class="my-3 p-3 bg-body rounded">
	<div class="row gx-3">
		<div class="alert alert-danger" role="alert">
			Les données ne sont pas prêtes Rappellez Aicha pour se remseigner
		</div>
	</div>
		<!--aicha_works_topに戻るリンク-->
		<div class="container mt-5">
		<a href="/aicha_works_top" class="text-primary">Retour</a>
		</div>
</div>

</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>