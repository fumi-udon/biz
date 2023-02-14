@extends('layouts.app')
@include('layouts.head')
<!-- パンくずリスト -->
@section('bread_name','Curry kitano')
@section('content')
<div class="row gx-3">
    <div class="col-md-2 center-block"><h3>Bouillons:</h3></div>
    <div class="col-md-10">
        <input type="number" id="number" name="number" value="" style="font-size:2em;width:140px;border: 1px solid gray;border-radius: 5px;">
        <input type="submit" value="click" onclick="calcurry()" style="margin-left:10px;font-size:14px;" class="btn btn-outline-primary">
    </div>
</div><!--インライングリッド row end-->

<div class="row gx-3 justify-content-start" style="margin-top:16px;border: 1px solid gray;border-radius: 5px;"><!--インライングリッド row-->
    <div class="col-md-6"> <p>PATE DU CURRY: <span id="roux" style="color:red;font-size:1.5em;"></span> g</p></div>
    <div class="col-md-6"> <p>POUDRE: <span id="poud" style="color:blue;font-size:1.5em;"></span> g</p></div>
</div><!--インライングリッド row end-->
@endsection

@section('footer')
<!-- [ADD]FUMI Javascripts currypateculs -->
<script src="{{ asset('js/currypateculs.js') }}"></script>
@endsection