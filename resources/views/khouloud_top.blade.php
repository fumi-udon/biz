@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">Khouloud! Good morgin</h1>
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-12">   

        <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col">Commencer</div>
                <div class="col-auto">
                <a href="khouloud_commence_input" class="btn btn-primary">select</a>
                </div>
            </div>
            </li>
        </ul>
        </div>
        </div>
        <!--topに戻るリンク-->
        <div class="container mt-5">
            <a href="/" class="text-decoration-none text-primary">Retour</a>
        </div>

    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

