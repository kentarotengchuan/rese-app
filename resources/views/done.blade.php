@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/done.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="box__thanks">
            <p class="thanks__text">ご予約ありがとうございます</p>
            <form action="{{ route('detail',['id'=>$shop->id]) }}" method="get">
            @csrf
                <button type="submit">戻る</button>
            </form>
        </div>
    </div>
@endsection