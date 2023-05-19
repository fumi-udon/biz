@extends('layouts.app')
@extends('layouts.head')

<!-- メインエリア表示 -->
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

  <main class="container">
      <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
          <h1 class="h6 mb-0 text-white lh-1">Bistro Nippon</h1>
          <small>Since 2017</small>
        </div>
      </div>
    
      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Bureau</h6>
        <div class="d-flex text-muted pt-3">
         <a href="/matin8h">  
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>bonjour</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@8h</strong>
            salut . Consulter la tâche d'aujourd'hui
          </p>
        </div>
        <div class="d-flex text-muted pt-3">
        <a href="/soir15h">  
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>bonsoir</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@15h</strong>
            pour le soir
          </p>
        </div>
      </div>
      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">aicha</h6>
        <div class="d-flex text-muted pt-3">
         <a href="/bn_register_top">
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="" preserveAspectRatio="xMidYMid slice" focusable="false"><title>aicha</title><rect width="100%" height="100%" fill="#00ab4b"/><text x="10%" y="10%" fill="#00ab4b" dy="">aicha</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@15h</strong>
            veuillez enregistrer la quantité d'ingrédients restants.
          </p>
        </div>
      </div>    

      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">curry kitano</h6>
        <div class="d-flex text-muted pt-3">
        <a href="/calcs">
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="" preserveAspectRatio="xMidYMid slice" focusable="false"><title>kitano</title><rect width="100%" height="100%" fill="#ffd900"/><text x="10%" y="10%" fill="#ffd900" dy="">curry</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">calcul de la pâte</strong>
             assaisonnement au curry
          </p>
        </div>
      </div>

      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">レシピ集 / Recettes</h6>
        <div class="d-flex text-muted pt-3">
         <a href="/recettes_index">
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="" preserveAspectRatio="xMidYMid slice" focusable="false"><title>recettes</title><rect width="100%" height="100%" fill="#1100dd"/><text x="10%" y="10%" fill="#ff99cc" dy="">レシピ</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">bistro nippon の味</strong>
          </p>
        </div>
      </div>

      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Gestion</h6>
        <div class="d-flex text-muted pt-3">
         <a href="/stock_email">
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="" preserveAspectRatio="xMidYMid slice" focusable="false"><title>gestion</title><rect width="100%" height="100%" fill="#ffd0dd"/><text x="10%" y="10%" fill="#ffd900" dy="">curry</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">ディナーストック管理</strong>
            TestDevController::stock_email() call <br>ディナー営業時間内のストック状況をCronで把握(19H/20H/21H)
          </p>
        </div>
      </div>

      <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">遊びふみ</h6>
        <div class="d-flex text-muted pt-3">
         <a href="/dev_home">
         <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="" preserveAspectRatio="xMidYMid slice" focusable="false"><title>gestion</title><rect width="100%" height="100%" fill="#ffd0dd"/><text x="10%" y="10%" fill="#ffd900" dy="">curry</text></svg>
        </a>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">開発遊び</strong>
          </p>
        </div>
      </div>
       
    </main>
    @endsection
<!-- メインエリア表示　END-->

@extends('layouts.footer')