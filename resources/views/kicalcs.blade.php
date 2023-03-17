@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start -->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">curry kitano</h1>
            <small>calc</small>
        </div>
    </div>

    <div class="my-3 p-2 bg-body rounded shadow-sm">

        <div class="form-group-lg d-flex">
            <label class="control-label me-2" for="lg">Bouillons</label>
            <div class="col-sm-3">
                <input class="form-control input-lg" id="number" name="number" type="number">
            </div>
            <div class="col-sm-5 ms-1">
                <button type="submit" class="btn btn-primary" onclick="calcurry()">calc</button>
            </div>                
        </div>


        <p class="pb-3 mb-0 small lh-sm">
            <div class="col-md-6"> <p>PATE DU CURRY: <span id="roux" style="color:red;"></span> g</p></div>
            <div class="col-md-6"> <p>POUDRE: <span id="poud" style="color:red;"></span> g</p></div>
        </p>

    </div>
</main>
<!-- end -->
@endsection

@extends('layouts.footer')
<!-- [ADD]FUMI Javascripts currypateculs -->
<script src="{{ asset('js/currypateculs.js') }}"></script>
