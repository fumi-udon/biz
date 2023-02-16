@extends('layouts.app')
@include('layouts.head',['bread_name' => '食材消費量'])
<!-- パンくずリスト -->

@section('content')
<h4>ConsumedFoodQuantity page </h4>
<div class="row gx-3">
    <div class="col-md-12 center-block">
		{{ $temp_table_radojson }}
    </div>
</div><!--インライングリッド row end -->

@if(Request::is('xxx'))

@endif

<!--テスト　デバック-->

@endsection

@section('footer')
@endsection