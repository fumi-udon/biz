@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- @Fumi old -->
<!-- @Fumi old end-->

<main class="container">
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<h6 class="border-bottom pb-2 mb-0">Bonjour ! 8H &#128536;</h6>
	<div class="d-flex text-muted pt-3">
		<p class="pb-3 mb-0 small lh-sm border-bottom">
	@if (@$yes_sato)
		{{-- サト指示があった場合 --}}
		&#x1f308;{!! $sato_instruction['override_tx_1'] !!}
	@else
	{{-- 通常入力 --}}
		<form action="task8h" method="post">
		@csrf
			<p style='padding:10px;'>
			Combien d'udon dans le frigo? <br>
			<input style="margin-right:5px;" type="number" id="rest_udn" name="rest_udn" min="0" max="25" value="{{ Session::get('rest_udn') }}" required>
			<input type="submit" value="suivant" class="btn btn-primary btn-round">
			<input type="hidden" name="actual_page_id" id="actual_page_id" value="matin8h_page1">
			</p>
		</form>
	@endif	
		</p>
	</div>
	@if(Request::is('task8h'))
	<!--task8hのページのみ表示  -->
	{{-- 通常指示 --}}
	<div class="text-muted pt-3">
		<p class="pb-3 mb-0 small lh-sm border-bottom">            
			<p><b>&#129508; ramen à mélanger et le couper pour aujourd'hui : </b> {{ $rmn_today }}<br></p>
			<p><b>&#9889; udon à couper pour ce matin : </b>{{ $udon_today }}</p>
		</p>
		<p style="margin:15px;">
		@if (!empty($note_today))
    		{{-- メモがあった場合 --}}
    		&#x1f408; <span style="color:red">NOTE: {!! $note_today !!} </span>
		@endif
		</p>
	</div>
	@endif
	</div>
</div>
</main>

<!-- Note 入力エリア start-->
<div class="col-md-12">
	@if(Request::is('add_note8h'))
	<hr>
	<p class="p-3"><b>登録しました</b><br>表示日：{{ session('note_date') }}<br>{{ session('note8h') }}</p>
	@endif
	<p class="m-2"><a href="javascript:void(0)" id="note_open">詳細</a></p>
	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="display:none; width: 80%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('add.note8h') }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp </label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary" name="alice_btn">登録</button>
		</form>

		<div class="my-3 p-3"><ul class="list-group">
			<li class="list-group-item">Dits mme.kadhija demain matin: vous n'avez pas besoin de préparer du curry, veuillez donc nettoyer la cuisine</li>
			<li class="list-group-item">Préparer du curry comme habitude </li>
		</ul></div>

		</div>
	</div><!--row end -->
	<!-- sato独自指示 エリア end -->
	</div>
<!-- Note 入力エリア end-->
@endsection

@extends('layouts.footer')