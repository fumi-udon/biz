
@extends('layouts.app')
@section('content')
<div class="row gy-3 px-3">
    <div class="p-3 bg-warning text-dark col-md-4">
    GIT の情報
    </div>
    <div class="p-3 bg-warning text-dark col-md-6">
    https://github.com/fumi-udon/biz.git
    </div>
</div>

<div class="row gy-3 px-3">
    <div class="p-2 bg-warning text-dark col-md-4">
    Database情報
    </div>
    <div class="p-2 bg-warning text-dark col-md-6">
    .env.production ファイルに記載してます。
    </div>
</div>

<div class="row gy-3 px-3">
    <div class="p-2 bg-warning text-dark col-md-4">
    関連ファイル
    </div>
    <div class="p-2 bg-warning text-dark col-md-6">
    RadoSimpleController.php / rado_simple.blade.php
    </div>
</div>

<div class="row gy-3 px-3">
    <div class="p-2 bg-warning text-dark col-md-4">
    ovhのログイン用 ssh
    </div>
    <div class="p-2 bg-warning text-dark col-md-6">
    ssh bistrgr@ssh.cluster031.hosting.ovh.net -p 22
    </div>
</div>
@endsection