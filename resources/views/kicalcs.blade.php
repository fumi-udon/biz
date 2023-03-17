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
            <small></small>
        </div>
    </div>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Bouillons</h6>
        <div class="text-muted pt-3">
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <input type="number" id="number" name="number" value="" style="font-size:2em;width:140px;border: 1px solid gray;border-radius: 5px;">
            <input type="submit" value="click" onclick="calcurry()" style="" class="btn btn-outline-primary"> 
         </p>
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
