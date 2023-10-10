@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<div class="my-3 p-3">
<h4>[共通] 追加上書き</h4>
<p>{!! $action_message !!}</p>
</div>
<!-- Note 入力エリア  start-->
<div class="col-md-12">

	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="width: 100%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('common.addnote.complete') }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="mode_inserts_list">上書き({!! $flg_oride !!}) / 追加({!! $flg_add !!})
					<select class="form-select" id="mode_inserts_list" name="mode_inserts_list" required>
						@foreach ($mode_inserts as $mode_insert)
							<option value="{{ $mode_insert['id'] }}" @if( Session::get('mode_insert_now')  == $mode_insert['id'] ) selected @endif> {{ $mode_insert['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 _ 例: @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp &#x1f320; </label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
			<input type="hidden" name="action_message" value="{!! $action_message !!}">
			<button type="submit" class="btn btn-primary" name="regist_btn">登録</button>
		</form>
		</div><!--row end -->
		<!-- sato独自指示 エリア end -->
	</div>
<!-- Note 入力エリア end-->

</main>
<!--インライングリッド row end -->

<!--テスト　デバック-->

@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/courses_matin.js') }}"></script>