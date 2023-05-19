@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">recettes</h1>
            <small>レシピ集</small>
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-12">   

        <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col">米炊き/ Le riz japonais</div>
                <div class="col-auto">
                <a href="riz_jp" class="btn btn-primary">go to page</a>
                </div>
            </div>
            </li>
        </ul>
        </div>

        </div>
        <div class="col-md-12">

        </div>
    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

