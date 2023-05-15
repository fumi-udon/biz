@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">dinner stock</h1>
            <small>riz</small>
        </div>
    </div>
    <div class="row gy-3">
    <div class="col-md-12">
        <h5>ディナーの米消費量</h5>        
        <table class="table" id="cry_record" style="">
            <thead>
                <tr>
                <th scope="col">設定範囲</th>
                <th scope="col">設定閾値</th>
                <th scope="col">米の消費量</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $startOfDayString }} ～ {{ $endOfDayString }}</td>
                <td>{{ $riz_dline }}</td>
                <td>{{ $riz_grammes }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

