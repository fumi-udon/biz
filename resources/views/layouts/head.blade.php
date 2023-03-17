@section('head')  
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">ビスニチとキタノ</a>
        <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/emporter_index">注文データ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/conso">食材消費履歴</a>
            </li>
            @if(session('auth_flg'))
            <li class="nav-item">
              <a class="nav-link" href="/index_finance">財務</a>
            </li>
            @endif
          </ul>
          <form class="d-flex" name="form_adpage" id="form_adpage" method="post" action="javascript:void(0)">
            @csrf
            <input class="form-control me-2" type="text" placeholder="管理者" aria-label="vip" id="input_pass" name="input_pass" >
            <button class="btn btn-outline-success" type="submit" name="validate_admin" id="validate_admin">submit</button>            
          </form>
          <div class="" name="view_ermsg" id="view_ermsg" data-ermsg="fumi error msg area"></div>       
        </div>
      </div>
    </nav>

    <div class="nav-scroller bg-body shadow-sm">
      <nav class="nav nav-underline" aria-label="Secondary navigation">
        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        <a class="nav-link" href="#">
          Bistro Nippon
          <span class="badge bg-light text-dark rounded-pill align-text-bottom">0</span>
        </a>
        <a class="nav-link" href="#">
          Curry Kitano
          <span class="badge bg-light text-dark rounded-pill align-text-bottom">00</span>
        </a>
      </nav>
    </div>
@endsection