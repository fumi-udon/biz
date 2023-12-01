@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">Courses pour le matin</h1>
		<small></small>
	</div>
</div>

<div class="my-3 p-3 bg-body rounded">
	<div class="row gx-3">
	@if( Session::has('sato_record') )			
			<div class="alert alert-primary" role="alert">
				<b>&#3889;<br> {!! Session::get('sato_record')->override_tx_1 !!} </b>
			</div>	
		@elseif ( isset($stock_record) )
			<div style=''>
			<p>
				&#128019; Poulet  {{ $courses_poulet }} pièces
			</p>
			@if ($bilel_lait === 0)
				<p>&#129371; Lait 4 paquets</p> 
			@elseif ($bilel_lait === 1)
				<p>&#129371; Lait 2 paquets</p> 
			@endif

			@if ($apple_days && $stock_cuisine_main['apple'] < 3)
					<p>&#x1f34e; Pomme 3 pièces</p>
			@elseif (! $apple_days)
				りんご買うなー
			@endif
			</div>
		@else
			@if (!Request::is('addnote_courses'))
			<div class="alert alert-danger" role="alert">
				Les données ne sont pas prêtes Rappellez Bilel pour se remseigner <br> TEL: 55 240 581
			</div>
			@endif
		@endif
	</div>
	        <!--aicha_works_topに戻るリンク-->
			<div class="container mt-5">
            <a href="/aicha_works_top" class="text-primary">Retour</a>
        	</div>
</div>

<!-- Note 入力エリア ◆通常は非表示 start-->
<div class="col-md-12">
	@if(Request::is('addnote_courses'))
	<hr>
	<p class="p-3"><b>登録しました。flg=4</b><br>表示日：{{ session('note_date') }}<br>{{ session('note8h') }}</p>
	@endif
	<div style="text-align: right;">
		<p class="m-2 small"><a href="javascript:void(0)" id="note_open" style="color: grey;">詳細</a></p>
	</div>
	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 100%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('addnote.courses') }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 _ 例:&#128019; Poulet  x pièces @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp &#129371; Lait  4 paquets</label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="alice_btn">登録</button>
		</form>
		</div><!--row end -->
		<!-- sato独自指示 エリア end -->

		<!-- Bilel登録データ -->
		@if ( isset($stock_ingredients) )
		<div class="my-3">
			<B>Bilel登録データ StockIngredientテーブル / flg 2 </B><br>
			<div class="table-responsive">	
				<table class="table">
					<thead>
						<tr>
						<th scope="col">registre</th>
						<th scope="col">chashu</th>
						<th scope="col">paiko</th>
						<th scope="col">poulet_cru</th>
						<th scope="col">lait</th>
						<th scope="col">riz</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($stock_ingredients_display as $record)
						<tr>
							@foreach ($record as $value)
								<td>{{ $value }}</td>
							@endforeach
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endif
		<!-- Bilel登録データ end-->
	</div>
<!-- Note 入力エリア end-->

</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>