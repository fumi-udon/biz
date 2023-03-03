@extends('layouts.app')
@include('layouts.head',['bread_name' => 'Bureau items'])
<!-- パンくずリスト -->
@section('content')
<h4>Bonsoir ! saisir des restes des ingrédients</h4>

@if (Session::has('flash_message'))
<div class="alert alert-success" role="alert">
	<p>{!! session('flash_message') !!}</p>	
</div>
@endif

<div class="container px-1">
<form method='POST' action="{{ route('bureau.store',['id' => '1','shop' => 'bistronippon']) }}">
<div class="row gx-1">
@csrf
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="fmg_list"><b>&#9859;Fromage チーズ</b> <br> How many?
			<select class="form-select" id="fmg_list" name="fmg_list" required>
				@foreach ($fromages as $fmg)
					<option value="{{ $fmg['id'] }}" @if( Session::get('fmg_now')  == $fmg['id'] ) selected @endif> {{ $fmg['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="rmn_list"><b>&#9859;Ramen boites</b> <br> How many?
			<select class="form-select" id="rmn_list" name="rmn_list" required>
				@foreach ($rmn_tappers as $tapper)
					<option value="{{ $tapper['id'] }}" @if( Session::get('tapper_now')  == $tapper['id'] ) selected @endif> {{ $tapper['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="tntn_list"><b>&#9859;Tantan </b> <br> How many?
			<select class="form-select" id="tntn_list" name="tntn_list" required>
				@foreach ($tantans as $tntn)
					<option value="{{ $tntn['id'] }}" @if( Session::get('tntn_now')  == $tntn['id'] ) selected @endif> {{ $tntn['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
</div><!--row end-->
<hr>
<!--row 2行目-->
<div class="row gx-1">
@csrf
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="fmg_list"><b>&#9859;Fromage チーズ</b> <br> How many?
			<select class="form-select" id="fmg_list" name="fmg_list" required>
				@foreach ($fromages as $fmg)
					<option value="{{ $fmg['id'] }}" @if( Session::get('fmg_now')  == $fmg['id'] ) selected @endif> {{ $fmg['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="rmn_list"><b>&#9859;Ramen boites</b> <br> How many?
			<select class="form-select" id="rmn_list" name="rmn_list" required>
				@foreach ($rmn_tappers as $tapper)
					<option value="{{ $tapper['id'] }}" @if( Session::get('tapper_now')  == $tapper['id'] ) selected @endif> {{ $tapper['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="tntn_list"><b>&#9859;Tantan </b> <br> How many?
			<select class="form-select" id="tntn_list" name="tntn_list" required>
				@foreach ($tantans as $tntn)
					<option value="{{ $tntn['id'] }}" @if( Session::get('tntn_now')  == $tntn['id'] ) selected @endif> {{ $tntn['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
</div>
<!--row 2行目 end-->
<div class="row p-2">
	<div class="col-md-12">
	<input type="submit" value="store" name="bureau_store" class="btn btn-primary btn-round">
	</div>
</div><!--row end-->
</form>
</div><!--コンテナー end -->

<!--テスト　デバック-->

@endsection

@section('footer')
@endsection