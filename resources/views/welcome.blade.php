
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

<div class="row gy-5 px-5 p-5">
<div class="col-md-12">
    <div class="text-muted"><a class="navbar-brand" href="/admin"><u>Administrateur</u></a></div>
</div>
</div>

<form name="form_adpage" id="form_adpage" method="post" action="javascript:void(0)">
@csrf
    <div class="form-group">
    <label for="inputadminpass">管理者パスワード</label>
    <input type="text" id="input_pass" name="input_pass" class="form-control">
    </div>
    <button name="validate_admin" id="validate_admin">ボタン</button>
</form>

<div name="view_ermsg" id="view_ermsg" data-ermsg="fumi error msg area"></div>
<script src="{{ mix('js/fumi0214.js') }}"></script> 
@endsection