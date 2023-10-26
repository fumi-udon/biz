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
			</ul>
		</div>
	</div><!--row end  -->
</main>
@endsection

@extends('layouts.footer')