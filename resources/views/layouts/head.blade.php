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
              <a class="nav-link" href="/close_top">CLOSE Check</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=0&single=true"  target="_blank">Shift</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://docs.google.com/document/d/1Mut-8_P-islhKel0PlYEULjw3jUgndNPtJDSzn9hnFk/edit?usp=sharing"  target="_blank">Plan de nettoyage</a>
            </li>
            @if(session('auth_flg'))
            <li class="nav-item">
              <a class="nav-link" href="/admin_top_menu">管理者メニューページ</a>
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

    <!-- <div class="nav-scroller bg-body shadow-sm">
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
    </div> -->
@endsection