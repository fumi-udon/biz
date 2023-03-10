@extends('layouts.app')
@section('content')
@if(isset( $action_message ))
<!-- アクションメッセージ表示 -->
<div class="row gy-3 p-3">
    <div class="" role="alert">    
    <ul class="list-group">
        <li class="list-group-item list-group-item-danger">{{ $action_message }}</li>
    </ul>
    </div>
</div>
@endif

<div class="row gy-3 px-3">
    <div class="col-md-3">
    <div class="p-3 border bg-primary text-white"><a class="navbar-brand" href="/matin8h">Chantal 8H</a></div>
    </div>
    <div class="col-md-3">
    <div class="p-3 border bg-primary text-white"><a class="navbar-brand" href="/soir15h">Chantal 15H</a></div>
    </div>
    <div class="col-md-3">
    <div class="p-3 border p-3 mb-2 bg-info text-dark"><a class="navbar-brand" href="/bn_register_top">Aicha 15h</a></div>
    </div>
    <div class="col-md-3">
    <div class="p-3 border bg-warning text-dark"><a class="navbar-brand" href="/calcs">Curry Kitano Calcs</a></div>
    </div>
</div>
<div class="row gy-3 px-3">
    <div class="col-md-3">
    <div class="p-3 border bg-primary text-white"><a class="navbar-brand" href="/bureau_index">Bureau items</a></div>
    </div>

</div>

<form name="form_adpage" id="form_adpage" method="post" action="javascript:void(0)">
<div class="row gy-5 px-5 p-5">
    <div class="col-md-6">
        @csrf
        <div class="form-group">
            <label for="inputadminpass">管理者ページ</label>
            <input type="text" id="input_pass" name="input_pass" class="form-control">
            <div class="" name="view_ermsg" id="view_ermsg" data-ermsg="fumi error msg area"></div>
            <div class="px-1 p-2">
            <button class="btn btn-primary" type="button" name="validate_admin" id="validate_admin">認証</button>
            </div>
        </div>
        <div class="px-1 p-4">            
            <div class="text-white">
            <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action list-group-item-success"><a href="/emporter_index">オーダーデータ</a> </li>
            <li class="list-group-item list-group-item-action list-group-item-success"><a href="/conso">食材消費ページ</a> </li>
            </ul>
            </div>
        </div>
    </div>
</div>
</form>
<script src="{{ mix('js/fumi0214.js') }}"></script> 
@endsection