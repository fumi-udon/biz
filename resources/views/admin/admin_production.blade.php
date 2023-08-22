@extends('layouts.app')
<!-- パンくずリスト -->
@extends('layouts.head')
@section('content')

<main class="container">

@if($action_message)
<!-- アクションメッセージ表示 -->
<div class="alert alert-success" role="alert">
  <p>{{ $action_message }}</p>
  <p> {{ session('sato_type') }}</p>
  <p> {{ session('sato_date') }}</p>
  <p> {{ session('sato_content') }}</p>
</div>
@endif
<div class="d-flex align-items-center p-3 my-3 text-white bg-fumi-1 rounded shadow-sm">
	<img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
	<div class="lh-1">
		<h1 class="h6 mb-0 text-white lh-1">サト指示ページ</h1>
		<small>sato data</small>
	</div>
</div>
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<div class=" text-muted pt-3 pb-3">
		<form method='POST' action="{{ route('update',['btn' => 'ramen']) }}">
            @csrf
			<p></h4>らーめん 切る数</h4></p>
			月曜:  <input type="number" value="{{ $plan_production['rmn_mon'] }}" name="rmn_mon" id="rmn_mon" size="6" maxlength="2" required><br>
			火曜:  <input type="number" value="{{ $plan_production['rmn_tue'] }}" name="rmn_tue" id="rmn_tue" size="6" maxlength="2" required><br>
			水曜:  <input type="number" value="{{ $plan_production['rmn_wed'] }}" name="rmn_wed" id="rmn_wed" size="6" maxlength="2" required><br>
			木曜:  <input type="number" value="{{ $plan_production['rmn_thu'] }}" name="rmn_thu" id="rmn_thu" size="6" maxlength="2" required><br>
			金曜:  <input type="number" value="{{ $plan_production['rmn_fri'] }}" name="rmn_fri" id="rmn_fri" size="6" maxlength="2" required><br>
			土曜:  <input type="number" value="{{ $plan_production['rmn_sat'] }}" name="rmn_sat" id="rmn_sat" size="6" maxlength="2" required><br>
			日曜:  <input type="number" value="{{ $plan_production['rmn_sun'] }}" name="rmn_sun" id="rmn_sun" size="6" maxlength="2" required><br>
			
			<p style="margin:5px;">
				<input type="submit" name="update_ramen" value="ramen更新" class="btn btn-primary"/>
			</p>
		</form>
    </div>
</div><!--インライングリッド row end -->
<hr/>
<!-- Udon エリア start -->
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<div class=" text-muted pt-3 pb-3">
		<form method='POST' action="{{ route('update',['btn' => 'udon']) }}">
            @csrf
			<p>
			<p></h3>Udon AM 設定値</h3></p>
			月曜:  <input type="number" value="{{ $plan_production['udon_base_mon'] }}" name="udon_base_mon" id="udon_base_mon" size="6" maxlength="2" required><br>
			火曜:  <input type="number" value="{{ $plan_production['udon_base_tue'] }}" name="udon_base_tue" id="udon_base_tue" size="6" maxlength="2" required><br>
			水曜:  <input type="number" value="{{ $plan_production['udon_base_wed'] }}" name="udon_base_wed" id="udon_base_wed" size="6" maxlength="2" required><br>
			木曜:  <input type="number" value="{{ $plan_production['udon_base_thu'] }}" name="udon_base_thu" id="udon_base_thu" size="6" maxlength="2" required><br>
			金曜:  <input type="number" value="{{ $plan_production['udon_base_fri'] }}" name="udon_base_fri" id="udon_base_fri" size="6" maxlength="2" required><br>
			土曜:  <input type="number" value="{{ $plan_production['udon_base_sat'] }}" name="udon_base_sat" id="udon_base_sat" size="6" maxlength="2" required><br>
			日曜:  <input type="number" value="{{ $plan_production['udon_base_sun'] }}" name="udon_base_sun" id="udon_base_sun" size="6" maxlength="2" required><br>
			<hr/>
			<p></h3>Udon PM 設定値</h3></p>
			月曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_mon'] }}" name="udon_base_mon2" id="udon_base_mon2" size="6" maxlength="2" required><br>
			火曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_tue'] }}" name="udon_base_tue2" id="udon_base_tue2" size="6" maxlength="2" required><br>
			水曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_wed'] }}" name="udon_base_wed2" id="udon_base_wed2" size="6" maxlength="2" required><br>
			木曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_thu'] }}" name="udon_base_thu2" id="udon_base_thu2" size="6" maxlength="2" required><br>
			金曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_fri'] }}" name="udon_base_fri2" id="udon_base_fri2" size="6" maxlength="2" required><br>
			土曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_sat'] }}" name="udon_base_sat2" id="udon_base_sat2" size="6" maxlength="2" required><br>
			日曜:  <input type="number" value="{{ $plan_production_idtwo['udon_base_sun'] }}" name="udon_base_sun2" id="udon_base_sun2" size="6" maxlength="2" required><br>
			</p>
			<p style="margin:5px;"><input type="submit" name="update_udon" value="udon更新" class="btn btn-primary"/></p>
		</form>
    </div>
</div><!--インライングリッド row end -->
<!-- Udon エリア end -->
<hr/>
<!-- sato独自指示 エリア end -->
<div class="my-3 p-3 bg-body rounded shadow-sm">
	<div class=" text-muted pt-3 pb-3">
	<h4> サト手動指示 </h4>
	<form method='POST' action="{{ route('admin.store',['btn' => 'sato']) }}">
        @csrf
		<div class="row mb-3">
			<label for="sato_type" class="col-sm-4 col-form-label">8時(1) or 15時(2)</label>
			<div class="col-sm-7">
			<input type="number" class="form-control" id="sato_type" name="sato_type" value="{{ session('sato_type') }}" required>
			</div>
		</div>
		<div class="row mb-3">
			<label for="sato_date" class="col-sm-4 col-form-label">表示日</label>
			<div class="col-sm-7">
			<input type="date" class="form-control" name="sato_date" id="sato_date" value="{{ session('sato_date') }}" required>
			</div>
		</div>
		<div class="row mb-3">
			<label for="sato_content" class="col-sm-4 col-form-label">内容 @php echo (htmlspecialchars('<br>', ENT_QUOTES)) @endphp </label>
			<div class="col-sm-7">
				<textarea style="width: 98%;height:100px;" class="Form-Item-Textarea" name="sato_content" id="sato_content" value=""required>{{ session('sato_content') }}</textarea>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" name="sato_btn">登録</button>
	</form>
		<div class="row mb-3">
			<div class="col-sm-7">
				example: <br>
				🧤 ramen à mélanger et le couper pour aujourd'hui : ?? <br> ⚡ udon à couper pour ce matin : ??
				<br><br>				
				<p>&#128019; Poulet  x pièces <pre>&lt;br&gt;</pre> &#129371; Lait  4 paquets</p>
			</div>
		</div>
	</div>
</div><!--row end -->
<!-- sato独自指示 エリア end -->
<hr/>

<!--container ストック残表示-->
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<div class=" text-muted pt-3 pb-3">
			<h5>StockIngredient テーブル </h5>
		</div>
		<table class="table">
			<thead>
				<tr>
				<th scope="col">日付</th>
				<th scope="col">うどん</th>
				<th scope="col">米</th>
				<th scope="col">ブイヨン</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($stock_ingredients as $stock_ingredient)
				<tr>
				<th>{{ $stock_ingredient->registre_date }}</th>
				<td>{{ $stock_ingredient->udon }}</td>
				<td>{{ $stock_ingredient->riz }}</td>
				<td>{{ $stock_ingredient->bouillons }} L</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<!--row end-->

</main>
@endsection

@extends('layouts.footer')