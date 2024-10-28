@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-all.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="form__search">
            <form action="{{route('index')}}" method="get">
                <select name="area" id="area" onchange="this.form.submit()">
                    <option value="all">All</option>
                    @foreach ($areas as $area)
                    <option value="{{$area->id}}" {{request('area') == $area->id ? 'selected' : ''}}>
                        {{$area->name}}
                    </option>
                    @endforeach
                </select>
                <select name="genre" id="genre" onchange="this.form.submit()">
                    <option value="all">All</option>
                    @foreach ($genres as $genre)
                    <option value="{{$genre->id}}" {{request('genre') == $genre->id ? 'selected' : ''}}>
                        {{$genre->name}}
                    </option>
                    @endforeach
                </select>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search…">
            </form>
        </div>
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
                            <button type="submit" name="from" value="index">詳しく見る</button>
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