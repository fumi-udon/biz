@section('head')
<header class="header">
<div class="row gx-3"><!--インライングリッド row-->
    <!--パンくずリスト-->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        @if(Request::is('conso'))
        <li class="breadcrumb-item"><a href="/admin">admin</a></li>
        @endif        
        <li class="breadcrumb-item active" aria-current="page">{{ $bread_name }}</li>
    </ol>
    </nav>
    <!--パンくずリスト end-->
</div><!--インライングリッド row end-->
</header>
@endsection