@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/review.css')}}">
@endsection
@section('main')
<div class="content">
    <div class="nav">
        <form action="{{ route('back') }}" method="post">
        @csrf
            <button class="button__nav" type="submit"><</button>
        </form>
        <h2 class="ttl">レビュー</h2>
    </div>
    <div class="box__review">
        <div class="box__ttl">
            <p class="text__ttl">{{$reservation->shop->name}}</p>
        </div>
        <div class="form__review">
            <form action="{{ route('review') }}" method="post" id="review">
            @csrf
                <input class="input__review" type="hidden" name="shop_id" value={{$reservation->shop->id}}>
                <input class="input__review" type="hidden" name="reservation_id" value={{$reservation->id}}>
                <select class="select__review" name="rating" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} ★</option>
                @endfor
                </select>
                <textarea class="textarea__review" name="content" id="" cols="30" rows="10" placeholder="レビュー内容を入力"></textarea>
            </form>
            <div class="button__inner">
            <button class="button__review" type="submit" form="review">レビューを投稿する</button>
            </div>
        </div>
    </div>
</div>
@endsection