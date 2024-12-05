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
                        <img class="img__shop" src="{{ asset('storage/shop_images/'.$shop->img_path) }}" alt="">
                    </div>
                    <h2 class="ttl__shop">{{$shop->name}}</h2>
                    <div class="tags__shop">
                        <span class="tag">#{{$shop->area->name}}</span>
                        <span class="tag">#{{$shop->genre->name}}</span>
                    </div>
                    <div class="buttons">
                        <form action="{{ route('detail',['id'=>$shop->id]) }}" method="get">
                        @csrf
                            <button class="button__detail" type="submit" name="from" value="index">詳しく見る</button>
                        </form>
                        <form action="{{ route('like',['id'=>$shop->id]) }}" method="post">
                        @csrf
                            <button type="submit">                        <svg class="heart {{        $shop->likedOrNot(auth()->user())? 'liked' : '' }}"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
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
        if (search) { 
            $.ajax({
                url: '/',
                method: 'GET'
            });
        }
    });
    });
    </script>
    
@endsection