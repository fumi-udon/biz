@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- @Fumi old -->
<!-- @Fumi old end-->

<main class="container">
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<h6 class="border-bottom pb-2 mb-0">Bonjour! &#128536;</h6>
	<div class="d-flex text-muted pt-3">
		<p class="pb-3 mb-0 small lh-sm border-bottom">
	{{-- 通常入力 --}}
		<form action="preparer_list" method="post">
		@csrf
			<div class="p-3 border bg-light">
				<div class="form-group">
					<label for="rizs_list"><b>&#127834;Reste de riz ce matin? </b>
					<select class="form-select" id="rizs_list" name="rizs_list" required>
						@foreach ($rizs as $riz)
							<option value="{{ $riz['id'] }}" @if( Session::get('riz_now')  == $riz['id'] ) selected @endif> {{ $riz['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			<input type="submit" value="suivant" class="btn btn-primary btn-round">
			<input type="hidden" name="actual_page_id" id="actual_page_id" value="aicha_preparer">
		</form>
		</p>
	</div>
	@if(Request::is('preparer_list'))
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
				<br>&#128720; Si c'est peu : namuru, pudding, etc...
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
	<p class="m-2 text-secondary small"><a href="javascript:void(0)" id="note_open">詳細</a></p>
	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 80%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('addnote.preparer') }}">
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
	</div><!--row end -->
	<!-- sato独自指示 エリア end -->
	</div>
<!-- Note 入力エリア end-->
@endsection

@extends('layouts.footer')