@extends('layouts.app')
<!-- パンくずリスト -->
@extends('layouts.head')
@section('content')
<main class="container">
	<div class="row gx-3 p-3"><!--row start-->
		<div><h5>管理者メニューページ</h5></div>
		<div class="col-md-4 center-block">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="/index_finance">財務</a>
				</li>
				<li class="list-group-item">
					<a href="/admin">サト指示ページ</a>
				</li>
				<li class="list-group-item">
					<a href="/jesser_close_recettes_filter">ジェイセル レジ集計詳細</a>
				</li>
				<li class="list-group-item">
					<a href="/emporter_index">注文データ</a>
				</li>
				<li class="list-group-item">
					<a href="/conso">食材消費履歴</a>
				</li>
				<li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vSoeAbT528tCT8EvtCCGhnTjB8nLcokQIbaD8T_n2QIp3sCi-yyzu8-onDWgZZqrF1wha58BVJdYkJm/pubhtml?gid=0&single=true">価格表</a>
				</li>
			</ul>
		</div>
	</div><!--row end  -->
</main>
@endsection

@extends('layouts.footer')