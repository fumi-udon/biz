@extends('layouts.app')
<!-- パンくずリスト -->
@extends('layouts.head')
@section('content')
<main class="container">
	<div class="row gx-3 p-3"><!--row start-->
		<div><h5>staff page	</h5></div>
		<div class="col-md-4 center-block">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="/contact_urgent">Contact en urgent</a>
				</li>
				<!-- <li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=0&single=true"  target="_blank">Shift</a>
				</li> -->
				<li class="list-group-item">
					<a href="https://docs.google.com/document/d/1Mut-8_P-islhKel0PlYEULjw3jUgndNPtJDSzn9hnFk/edit?usp=sharing"  target="_blank">Plan de nettoyage</a>				
				</li>
				<li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vSVgQv9pqQcIwSavzFLFgugv1CbiTk4eCvosm6GffEEoF0d3wxkA29X7GvUdeECuoqOT3Sf_R4ROZmH/pubhtml?gid=0&single=true"  target="_blank">Shift pour la fin d'année</a>				
				</li>
			</ul>
		</div>
	</div><!--row end  -->

	<div class="row gx-3 p-3"><!--row start-->
		<div class="col-md-4 center-block">
			<ul class="list-group">
				<li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vSVgQv9pqQcIwSavzFLFgugv1CbiTk4eCvosm6GffEEoF0d3wxkA29X7GvUdeECuoqOT3Sf_R4ROZmH/pubhtml?gid=242477425&single=true"  target="_blank">planning des horaires</a>				
				</li>
				<li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vSVgQv9pqQcIwSavzFLFgugv1CbiTk4eCvosm6GffEEoF0d3wxkA29X7GvUdeECuoqOT3Sf_R4ROZmH/pubhtml?gid=1692662114&single=true"  target="_blank">changement de menu</a>				
				</li>
			</ul>
		</div>
	</div><!--row end  -->
</main>
@endsection

@extends('layouts.footer')