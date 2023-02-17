@extends('layouts.app')
<!-- パンくずリスト -->
@include('layouts.head',['bread_name' => '財務'])
@section('content')
<h4>Finance Page</h4>

<!--container 売上データ表示-->
<div class="container px-4 p-3">
	<div class="row gx-3">
		<div class="col-md-12 center-block">
			<h5>売上 テーブル </h5>
		</div>
	</div>
	<div class="row gx-1">
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

			</tbody>
		</table>
	</div><!--row end-->
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