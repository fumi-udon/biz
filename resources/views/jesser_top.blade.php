@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-recettes rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">Jesser</h1>
            <small> page d'accuil</small>
        </div>
    </div>

    <div class="my-3 p-2 bg-body rounded shadow-sm">
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Work's 
                <a href="jesser_works" class="btn btn-primary">click</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Finance 
                <a href="jesser_close_recettes" class="btn btn-primary">click</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Gestion de stock
                <a href="jesser_gestion_stock" class="btn btn-primary">click</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Côntrol de fermeture
                <form method='POST' action="{{ route('close.top',['id' => 'jesser_close','params' => 'jesser_close']) }}">
		            @csrf
                    <input type="submit" value="start check" name="click" class="btn btn-primary btn-round">
                </form>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                Journal
                <div class="col-8 col-md-4"> <!-- レスポンシブ対応の列幅指定 -->
                <form method="POST" action="{{ route('finance.journal',['id' => 'finance_journal','params' => 'finance_journal']) }}" class="d-flex align-items-end">
                    @csrf
                    <div class="input-group">
                        <input type="password" class="form-control form-control-sm" id="auth_pass_journal" name="auth_pass_journal" placeholder="Password" minlength="4" style="width: 30px;" required> <!-- 幅を指定 -->
                        <button type="submit" name="finance_journal" class="btn btn-warning btn-round">click</button>
                    </div>
                </form>
                </div>
            </li>            
        </ul>
    </div>
    </div><!--row end-->
    
    <div class="col-12 col-sm-6"> <!-- レスポンシブ対応の列幅指定 -->
        <a class="btn btn-dark btn-sm" id="start_zoom" role="button" href="javascript:void(0)"> Get meeting link </a>
        <p id="zoom_link_area" style="display:none; width: 100%;padding:20px;">
            <a class="" id="zoom_link" href="https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1"> https://us05web.zoom.us/j/84605269051?pwd=vaeJ8JwYmzOUR2vk2T0R5VBG88BIoT.1 </a>
        <p>
    </div>
</main>
<!-- end -->
@endsection
<script src="{{ asset('js/fumi0619_chklist.js') }}"></script>
@extends('layouts.footer')

