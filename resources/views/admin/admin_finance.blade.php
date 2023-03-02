@extends('layouts.app')
<!-- パンくずリスト -->
@include('layouts.head',['bread_name' => '財務'])
@section('content')
<h4>財務</h4>

<!--container 売上データ表示-->
<div class="container px-4 p-3">
	<div class="row gy-3 px-3">
		<div class="p-2 col-md-12">
		<h4>売上合計</h4>
		<table class="table">
			<thead>
				<tr>
				<th scope="col">年月</th>
				<th scope="col">金額（DT）</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($recettes_months as $recette) 
			<tr>
				@foreach ($recette as $month => $total) 
				<th scope="row">{{ $month }}</th>
				<td>{{ $total }} DT</td>         
				@endforeach
			</tr>
			@endforeach
			</tbody>
		</table>
		</div>
	</div>
</div><!--container end-->

<div class="container px-4 p-3">
	<div class="row gx-3 p-3">
		<div class="col-md-4 center-block">
		<ul class="list-group">
		<li class="list-group-item">
			<a href="/admin">Admin pageへ戻る</a>
		</li>
		</ul>
		</div>
	</div><!--row end-->
</div><!--container end-->
@endsection

@section('footer')
@endsection