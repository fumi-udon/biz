@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<main class="container">
<h4>ディナー指示追加上書き</h4>
<!-- Note 入力エリア ◆通常は非表示 start-->
<div class="col-md-12">
	@if(Request::is('addnote_diner'))
	<hr>
	<p class="p-3"><b>登録しました。Sato指示 flg=6(上書き) or 7(追加)</b><br>表示日：{{ session('note_date') }}<br>{{ session('mode_insert_now') }}<br>{{ session('note8h') }}</p>
	@endif

	<!-- sato独自指示 エリア end -->
	<div class="my-3 p-3 bg-body rounded shadow-sm" id="note_record" style="width: 80%;">
		<div class=" text-muted">
		<form method='POST' action="{{ route('addnote.diner') }}">
			@csrf
			<div class="row">
				<label for="note_date" class="col-form-label">表示日</label>
				<div class="">
				<input type="date" class="form-control" name="note_date" id="note_date" value="{{ session('note_date') }}" required>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="mode_inserts_list">上書きか追加 (6 / 7) 
					<select class="form-select" id="mode_inserts_list" name="mode_inserts_list" required>
						@foreach ($mode_inserts as $mode_insert)
							<option value="{{ $mode_insert['id'] }}" @if( Session::get('mode_insert_now')  == $mode_insert['id'] ) selected @endif> {{ $mode_insert['name'] }} </option>
						@endforeach
					</select>
					</label>
				</div>
			</div>
			<div class="row">
				<label for="note_content" class="col-form-label">内容 _ 例: @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp &#129371; </label>
				<div class="">
					<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="note8h" id="note8h" value=""required>{{ session('note8h') }}</textarea>
				</div>
			</div>
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