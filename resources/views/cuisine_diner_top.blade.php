@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<main class="container">
<div class="my-1 p-1 bg-body rounded shadow-sm">
	<h3 class="border-bottom pb-2 mb-0">Kitchen stocks</h3>
	@if (Session::has('flash_message'))
	<div class="my-1 p-1 bg-body rounded shadow-sm">
		<div class="alert alert-success" role="alert">
			<p>{!! session('flash_message') !!}</p>	
		</div>
	</div>
	@endif
	<div>
		<p class="">
	{{-- 通常入力 --}}
		<form action="cuisine_diner_task" method="post">
		@csrf
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="oeufs">oeuf</label>
						<select class="form-select" id="oeufs" name="oeufs" required>
						@foreach ($oeufs as $oeuf)
							<option value="{{ $oeuf['id'] }}" @if( Session::get('oeuf_now')  == $oeuf['id'] ) selected @endif> {{ $oeuf['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div>
				<!-- 一時帰国：ほうれん草 用 -->
				<div class="col-md-6">
					<div class="form-group">
						<label for="epinard" class="form-label">Epinard(grammes):</label>
						<input type="number" class="form-control" id="epinard" name="epinard" required>
					</div>
				</div>
				<!-- 夏：まぜそば用 -->
				<!-- <div class="col-md-6">
					<div class="form-group">
						<label for="omlettes">omlette émincée</label>
						<select class="form-select" id="omlettes" name="omlettes" required>
						@foreach ($omlettes as $omlette)
							<option value="{{ $omlette['id'] }}" @if( Session::get('omlette_now')  == $omlette['id'] ) selected @endif> {{ $omlette['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div> -->
			</div><!-- row end -->
			<hr>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="fms">fruits de mer</label>
						<select class="form-select" id="fms" name="fms" required>
						@foreach ($fms as $fm)
							<option value="{{ $fm['id'] }}" @if( Session::get('fm_now')  == $fm['id'] ) selected @endif> {{ $fm['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="laitues">laitue</label>
						<select class="form-select" id="laitues" name="laitues" required>
						@foreach ($laitues as $laitue)
							<option value="{{ $laitue['id'] }}" @if( Session::get('laitue_now')  == $laitue['id'] ) selected @endif> {{ $laitue['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div>
			</div><!-- row end -->
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="okonomiyakis">okonomiyaki</label>
						<select class="form-select" id="okonomiyakis" name="okonomiyakis" required>
						@foreach ($okonomiyakis as $okonomiyaki)
							<option value="{{ $okonomiyaki['id'] }}" @if( Session::get('okonomiyaki_now')  == $okonomiyaki['id'] ) selected @endif> {{ $okonomiyaki['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div>
			</div><!-- row end -->

			<div class="p-4">
				<input type="submit" value="suivant" class="btn btn-primary btn-round">
				<input type="hidden" name="actual_page_id" id="actual_page_id" value="cuisine_diner">
			</div>
		</form>
		</p>
	</div>
	</div>
</div>
	
<!-- Note サト指示共通ページへ　-->
@php
$flg_oride = 9;
$flg_add = 10;
$actionMessage = 'ディナー17h30 シャハルディンプレパレ用';
@endphp

    <p class="m-2 small">
        <a href="{{ route('common.addnote', ['flg_oride' => $flg_oride,'flg_add' => $flg_add, 'actionMessage' => $actionMessage]) }}" style="color: grey;">
            指示追加 
        </a>
    </p>

<!-- Note 入力エリア ◆通常は非表示 start-->
<div class="col-md-12">
	<div style="text-align: right;">
		<p class="m-2 small"><a href="javascript:void(0)" id="note_open" style="color: grey;">詳細</a></p>
	</div>
		<!-- 登録データ -->
		<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 100%;">

		@if ( isset($stock_mains) )
		<div class="my-3">
			<p>stock_mainsテーブル</p>
			<div class="table-responsive">	
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col">Epinard</th>
						</tr>
					</thead>
					<tbody>
					@foreach ($stock_mains as $stock_main)
						<tr>
							<td>{{ $stock_main->created_at }}</td>
							<td>{{ $stock_main->epinard }} g</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endif

		@if ( isset($stock_ingredients) )
		<div class="my-3">
			<p>登録データStockIngredientテーブル</p>
			<div class="table-responsive">	
				<table class="table">
					<thead>
						<tr>
						<th scope="col">registre_datetime</th>
						<th scope="col">oeuf</th>
						<th scope="col">omlette émincée</th>
						<th scope="col">fruits de mer</th>
						<th scope="col">laitue</th>
						<th scope="col">okonomiyaki</th>
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
		</div>
	</div>
<!-- Note 入力エリア end-->

</main>

@endsection
@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>