@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト -->
@section('content')
<!-- FUMI start -->
<main class="container">

<div class="container mt-5">
		<form method='POST' action="{{ route('jesser.close.recettes.filter.serch',['id' => 'jesser_record_day','params' => 'bistronippon']) }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">開始日</label>
                        <input type="date" class="form-control" id="startDate" name="startDate"  value="{{ Session::get('startDate') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="endDate" class="form-label">終了日</label>
                        <input type="date" class="form-control" id="endDate" name="endDate"  value="{{ Session::get('endDate') }}" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">実行</button>
        </form>
    </div>

<div class="col-md-12">
@if(!empty($ampm_merge_collection))
	<div class="table-responsive" style="width: 90%;">
	&#11093; finance table
	<table class="table table-striped" sytle ="min-width: 800px;">
		<thead>
			<tr>
				<th>Date time</th>
				<th>AM/PM</th>
				<th>cash</th>
				<th>cheque</th>
				<th>card</th>
				<th>chips</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ampm_merge_collection as $record)
				<tr>
					<td>{{ $record->registre_datetime }}</td>
					<td>{{ $record->zone }}</td>
					<td>{{ $record->cash }}</td>
					<td>{{ $record->cheque }}</td>
					<td>{{ $record->card }}</td>
					<td>{{ $record->chips }}</td>
				</tr>
			@endforeach
			<tr>
				<td></td>
				<td></td>
				<td>cash</td>
				<td>cheque</td>
				<td>card</td>
				<td>chips</td>
			</tr>
			<tr>  
					<td><b>TOTAL</b></td>
					<td></td>
					<td><b>{{ $total_cash }}</b></td>
					<td><b>{{ $total_cheque }}</b></td>
					<td><b>{{ $total_card }}</b></td>
					<td><b>{{ $total_chip }}</b></td>
				</tr>
		</tbody>
	</table>
	</div>
	@endif
</div>
<!-- Note 入力エリア end -->

<!-- [ADD]FUMI Javascripts  -->
<script src="{{ asset('js/fumi0307.js') }}"></script>

</main>
<!-- FUMI end -->
<!--テスト　デバック-->
@endsection

@extends('layouts.footer')