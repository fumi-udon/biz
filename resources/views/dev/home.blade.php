@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<h4>開発遊び用</h4>

<div class="row gx-3">
    <div class="col-md-12 center-block">		
		<div class="alert alert-primary" role="alert">
			<a href="/importCSV">importCSV </a>
			<p>C:\xampp\htdocs\business\public\csv から読み込み</p>
		</div>
    </div>
</div><!--インライングリッド row end -->

<!--テスト　デバック -->

@endsection

@extends('layouts.footer')