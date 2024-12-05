@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/success.css')}}">
@endsection
@section('main')
<div class="content">
    <div class="box__success">
        <h1 class="ttl__success">決済が成功しました。</h1>
        <a class="link__success" href="/mypage">マイページに戻る</a>
    </div>
</div>
@endsection