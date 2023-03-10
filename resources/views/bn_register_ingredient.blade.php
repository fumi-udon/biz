@extends('layouts.app')
@include('layouts.head',['bread_name' => '15h登録'])
<!-- パンくずリスト -->
@section('content')
<h4>Bonsoir Aicha ! 15H</h4>

@if (Session::has('flash_message'))
<div class="alert alert-success" role="alert">
	<p>{!! session('flash_message') !!}</p>	
</div>
@endif

<div class="container px-1">
<form method='POST' action="{{ route('bn.register.store',['id' => 'aicha','params' => 'bistronippon']) }}">
@csrf
  <div class="row gx-1">
    <div class="col-md-4">
     <div class="p-3 border bg-light">
	 	<div class="form-group">
			<label for="rizs_list"><b>&#9849;UDON </b>  <br>reste pour ce soir?
			<input type="number" id="udon_rest_8h" name="udon_rest_8h" min="0" max="19" value="{{ Session::get('udon_rest_8h') }}" class="form-control is-valid w20" required>
			</label>
		</div>
	 </div>
    </div>

    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
			<label for="rizs_list"><b>&#9859;Riz </b> <br> 0: zéro ～ 5: beaucoup
			<select class="form-select" id="rizs_list" name="rizs_list" required>
				@foreach ($rizs as $riz)
					<option value="{{ $riz['id'] }}" @if( Session::get('riz_now')  == $riz['id'] ) selected @endif> {{ $riz['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>

    <div class="col-md-4">
      <div class="p-3 border bg-light">
	  	<div class="form-group">
		    <label for="bouillons_list"><b>&#9969;Bouillons</b> <br> combien de litre?
			<select class="form-select" id="bouillons_list" name="bouillons_list" required>
				@foreach ($bouillons as $bouillon)
					<option value="{{ $bouillon['id'] }}" @if( Session::get('bouillon_now')  == $bouillon['id'] ) selected @endif> {{ $bouillon['name'] }} </option>
				@endforeach
			</select>
			</label>
		</div>
	  </div>
    </div>
    </div><!--row end-->

	<div class="row p-2">
		<div class="col-md-12">
		<input type="submit" value="enregistrer" name="enregistrer" class="btn btn-primary btn-round">
		</div>
	</div><!--row end-->
</form>
</div><!--コンテナー end -->

@if(Request::is('bn_register_top'))
	@env('local')
				<div class=""><h6>bn_register_ingredient.blade.php</h6></div>
				<div class=""><h6>TaskOrderController.php</h6></div>           
	@endenv
@endif

<!--テスト　デバック-->

@endsection

@section('footer')
@endsection