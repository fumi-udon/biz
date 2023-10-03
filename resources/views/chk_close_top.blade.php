@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">
	@if (Session::has('jesser_close') && session('jesser_close') )
		<p class="p-1 bg-light">Hi! Jesser</p>	
	@endif

	<div class="d-flex align-items-center p-3 my-3 text-white bg-pink rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1"> IMPORTANT! SECURITE</h1>
		<small>Closing Checklist</small>
	</div>
	</div>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
	  <div class="container px-1">
		<form method='POST' action="{{ route('close.step1',['id' => 'chk_top','params' => 'incendie']) }}">
		@csrf
		<div class="row gx-1"><!--row 1行目 start-->
			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="cles_de_gaz" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Les clés de gaz</b>
							<span style="color: red;">sécurité incendie</span>
							<input class="form-check-input ms-2" type="checkbox" id="cles_de_gaz" name="cles_de_gaz" value="{{ Session::get('cles_de_gaz') }}" data-bs-toggle="modal" data-bs-target="#clesgazModal" required>
							</label>
						</div>
						<img src="/img/gaz3.png" alt="Your Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="p-3 border bg-light">
					<div class="d-flex align-items-center">
						<div class="flex-grow-1">
							<label for="fritures" class="d-flex align-items-center">
							<b style="margin-right:10px;">&#9849;Les deux friture</b>
							<span style="color: red;">sécurité incendie</span>
							<input class="form-check-input ms-2" type="checkbox" id="fritures" name="fritures" value="{{ Session::get('fritures') }}" data-bs-toggle="modal" data-bs-target="#frituresModal" required>
							</label>
						</div>
						<img src="/img/flayerKasai.png" alt="flayerKasai Image" class="ms-1" style="width: 80px; height: 80px;">
					</div>
				</div>
			</div>
		</div><!--row 1行目 end-->

			<div class="row p-2">
				<div class="col-md-12">
				<input type="submit" value="confirmer" name="confirmer" class="btn btn-primary btn-round">
				</div>
			</div>
		</form>
	  </div><!--コンテナー end -->
    </div>
	<!-- 履歴表示 -->
	<div class="col-md-12">
	<h5>Histriques</h5>
	<table class="table" id="chkclose_record" style="display:block;">
		<thead>
			<tr>
			<th scope="col">ID</th>
			<th scope="col">Responsable</th>
			<th scope="col">DATE</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($records as $record)
		<tr>
			<td>{{ $record['id'] }}</td>
			<td>{{ $record['name'] }}</td>
			<td>{{ $record['formatted_created_at'] }}</td>
		</tr>
		@endforeach
		</tbody>
	</table>
	</div>
	<!--履歴表示 end-->
</main>

<!-- FUMI end -->
<!-- Modal friture start-->
<div class="modal fade" id="clesgazModal" tabindex="-1" aria-labelledby="clesgazModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clesgazModalLabel">sécurité incendie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <span style="color: red;">Attention au feu</span>
	  <img src="/img/firefigter.png" alt="flayerKasai Image" class="ms-1" style="width: 140px; height: 110px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Je garantie</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal friture end-->

<!--テスト　デバック-->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts -->
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>