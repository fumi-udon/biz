@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">レシピ集</h1>
            <small>recettes</small>
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-12">
            <h5>レシピ集</h5>        
            <table class="table" id="cry_record" style="">
                <thead>
                    <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Link</th>
                    <th scope="col">Note</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>米炊き/ Le riz japonais</td>
                    <td><a href='riz_jp'>go to page</a></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">

        </div>
    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

