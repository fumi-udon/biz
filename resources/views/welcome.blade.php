
@extends('layouts.app')
@section('content')
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

<form name="form_adpage" id="form_adpage" method="post" action="javascript:void(0)">
<div class="row gy-5 px-5 p-5">
    <div class="col-md-6">
        <div class="text-muted"><a class="navbar-brand" href="/admin"><u>Administrateur</u></a></div>
        @csrf
        <div class="form-group">
            <label for="inputadminpass">パスワード</label>
            <input type="text" id="input_pass" name="input_pass" class="form-control">
        </div>
        <div class="p-3">
            <div class="px-1 p-3">
            <button class="btn btn-primary" type="button" name="validate_admin" id="validate_admin">認証</button>
            </div>
            <div class="px-1 p-3" name="view_ermsg" id="view_ermsg" data-ermsg="fumi error msg area"></div>
        </div>
    </div>
</div>
</form>
<script src="{{ mix('js/fumi0214.js') }}"></script> 
@endsection