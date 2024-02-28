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
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=0&single=true"  target="_blank">Shift 2024</a>				
				</li>
			</ul>
		</div>
	</div><!--row end  -->

	<div class="row gx-3 p-3"><!--row start-->
		<div class="col-md-4 center-block">
			<ul class="list-group">
			<li class="list-group-item">
					<a href="https://docs.google.com/spreadsheets/d/e/2PACX-1vS6lt16gnKW-JH1ED3Vm6fqPWhRyjTxwhqDnQN2yu0EW4BlsX0H1lcvWrOPx-jVFFvYpu-9cfwtBIjb/pubhtml?gid=1289910994&single=true"  target="_blank">RAMADAN 2024</a>				
				</li>
			</ul>
		</div>
	</div><!--row end  -->
</main>
@endsection

@extends('layouts.footer')