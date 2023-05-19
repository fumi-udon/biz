@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->

@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-recettes rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">riz japonais</h1>
            <small>米の炊き方</small>
        </div>
    </div>

    <div class="my-3 p-2 bg-body rounded shadow-sm">

        <div style="font-family: Arial, sans-serif; line-height: 1.4;">
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">1.</span>
            Nettoyez le riz.
            <div>
                <img src="/img/riz_laver.jpg" alt="laver le riz photo">
            </div>
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">2.</span>
            Laissez-le reposer pendant 15 minutes minimum.
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">3.</span>
            Mettez-le sur le gaz à feu vif.
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">4.</span>
            Baissez le feu une fois qu'il a bouilli et réglez une minuterie de 12 minutes.
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">5.</span>
            Éteignez le feu après 12 minutes.
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">6.</span>
            Laissez reposer pendant 12 minutes sans ouvrir le couvercle.
            </div>
            <div class="step" style="margin-bottom: 10px;">
            <span class="number" style="color: blue;">7.</span>
            Remuez bien le riz.
            </div>
            <div class="step">
            C'est prêt!!
            </div>
        </div>

    </div><!--row end-->
</main>
<!-- end -->
@endsection

@extends('layouts.footer')

