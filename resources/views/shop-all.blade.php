@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-all.css')}}">
@endsection
@section('main')
    <div class="content">       
        <div class="flex">
            @foreach ($shops as $shop)
                <div class="box__shop">
                    <div class="img__inner">
                        <img src="{{ asset('storage/shop_images/'.$shop->img_path) }}" alt="">
                    </div>
                    <h2 class="ttl__shop">{{$shop->name}}</h2>
                    <div class="tags__shop">
                        <span class="area-tag">#{{$shop->area->name}}</span>
                        <span class="genre-tag">#{{$shop->genre->name}}</span>
                    </div>
                    <div class="buttons">
                        <form action="{{ route('detail',['id'=>$shop->id]) }}" method="get">
                        @csrf
                            <button class="button__detail" type="submit" name="from" value="index">詳しく見る</button>
                        </form>
                        <form action="{{ route('like',['id'=>$shop->id]) }}" method="post">
                        @csrf
                            <button type="submit">
                                <span class="heart {{ $shop->likedOrNot(auth()->user())? 'liked' : '' }}">&hearts;</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
    $('#search').on('input', function() {
        const search = $(this).val();
        if (search) { // 入力がある場合のみリクエストを送信
            $.ajax({
                url: '/',
                method: 'GET'
            });
        }
    });
    });
    </script>
    
@endsection