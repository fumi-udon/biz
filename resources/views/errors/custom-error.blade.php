@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">	

	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class="alert alert-danger" role="alert">
			<h1>ERROR !!</h1>
			<p>検索データがありません日付確認</p>
			<p>
					<a href="/jesser_close_recettes_filter">Back to Previous Page</a>
			</p>
		</div>		
	</div>

</main>

<!--テスト　デバック-->
@endsection
@extends('layouts.footer')
