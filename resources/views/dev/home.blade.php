@extends('layouts.app')
@extends('layouts.head')
<!-- パンくずリスト stock_record sato_record -->
@section('content')
<!-- start スタート-->
<main class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white bg-kitano rounded shadow-sm">
        <img class="me-3" src="{{ asset('img/bootstrap-logo-white.svg') }}" alt="" width="48" height="38">
        <div class="lh-1">
            <h1 class="h6 mb-0 text-white lh-1">アメキャンお手伝い</h1>
            <small>合同会社Amecan Japan</small>
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-12">
            <h5>Amecan Japan File importer</h5>			  
			<div class="my-3 p-2 bg-body rounded shadow-sm">
			@if(empty($filePath))    
				<div class="alert" role="alert">
				<p>カタカナのみ抽出してグループ化</p>
				<p style="color:red;">※ファイルの文字コードは UTF8のみ指定可能</p>
					<div id="excel-uploadzone">
						<form action="{{ route('dev.import.csv2') }}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"  accept=".csv">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
							<div class="grid grid-cols-1">
								<label class="uppercase md:text-sm text-xs text-red font-semibold mb-1">CSVファイルを選択（必須）</label>
								<input type='file' name='amecanjapan' />
									@error('amecanjapan')
										<div class="text-red-500 font-bold">{{ $message }}</div>
									@enderror
							</div>
						</div>
						<button type="submit" class='hover:bg-gray-700 text-blue font-bold py-1 px-3 mt-1 rounded'>実行</button>
						</form>
					</div>
				</div>
			@endif

			@if(!empty($filePath))
					<h2>正常終了</h2>
    				<p style="color:blue">ファイルの作成が完了しました。管理者にファイル名を連絡してください。: {{ $filePath }}</p>
					<p><a href="/dev_home">戻る</a></p>
						
			@endif
			</div>
        </div>
    </div><!--row end-->
</main>
<!-- end -->

<!--テスト　デバック -->

@endsection

@extends('layouts.footer')