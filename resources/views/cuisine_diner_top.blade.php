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
				<div class="col-md-6">
					<div class="form-group">
						<label for="omlettes">omlette émincée</label>
						<select class="form-select" id="omlettes" name="omlettes" required>
						@foreach ($omlettes as $omlette)
							<option value="{{ $omlette['id'] }}" @if( Session::get('omlette_now')  == $omlette['id'] ) selected @endif> {{ $omlette['name'] }} </option>
						@endforeach
						</select>
					</div>
				</div>
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
	@if(Request::is('cuisine_diner_task'))
	<hr>
	<!--preparer_listのページのみ表示  -->
	<div class="col-md-12  pt-3">
		<div class="pt-3">
		<h4>Préparation pour le matin</h4>
		@if ($yes_sato)
			{{-- サト指示があった場合 --}}
			<br>{!! $sato_instruction['override_tx_1'] !!}
		@else			
			<p class="pb-3">
				&#127833; RIZ:
				@if($req_riz == 0 || $req_riz == 1)
					12 p
				@elseif($req_riz == 2)
					10 p
				@elseif($req_riz == 3)
					7 p
				@elseif($req_riz == 4 || $req_riz == 5 || $req_riz == 6)
					4 p
				@elseif($req_riz == 7)
					0
				@endif
			</p>			
		@endif
			<p>
				&#128720; Si c'est peu : namuru, pudding, etc...
			</p>
			<p>
			&#x1f302; <span style="color:#111">Contact d'urgence: Bilel 55 240 581 </span>
			</p>
		</div>
	</div>
	@endif
	</div>
</div>
</main>

<!-- Note 入力エリア start-->
<div class="col-md-12">
	@if(Request::is('addnote_preparer'))
	<hr>
	<p class="p-3"><b>登録しました</b><br>表示日：{{ session('note_date') }}<br>{{ session('note8h') }}</p>
	@endif
	<div style="text-align: right;">
		<p class="m-2 small"><a href="javascript:void(0)" id="note_open" style="color: grey;">詳細</a></p>
	</div>
	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 80%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('common.addnote.complete',['flg' => '9', 'action_message' => 'キッチンディナープレパレ登録済']) }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp Aichaプレパレ用は　flg = 5</label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="alice_btn">登録</button>
		</form>
		</div>
		<!--row Aicha 入力データ表示 start -->
		<div class='col-md-12 m-2 p-3 text-secondary small'>
		@php
			$stock_ingredients = session('stock_ingredients');
		@endphp
		@if ($stock_ingredients)
			<table class="table">
				<thead>
					<tr>
					<th scope="col">DATE</th>
					<th scope="col">RIZ</th>
					</tr>
				</thead>
			@foreach ($stock_ingredients as $ingredient)
				<tbody>
					<tr>
					<td>{{ $ingredient->registre_datetime }}</td>
					<td>{{ $ingredient->riz }}</td>
					</tr>
				</tbody>
			@endforeach
			</table>
		@else
		@endif
		</div>
		<!--row Aicha 入力データ表示 end
	 -->
	</div><!--row end -->
	<!-- sato独自指示 エリア end -->
	</div>
<!-- Note 入力エリア end-->
@endsection

@extends('layouts.footer')