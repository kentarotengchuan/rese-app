@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-update.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="box__create">
            <div class="nav">
                <form action="{{ route('back') }}" method="post">
                @csrf
                <button type="submit"><</button>
            </form>
                <p class="ttl__create">店舗情報の更新</p>
            </div>
            <form action=" {{route('update-shop')}} " method="post">
            @csrf
                <input type="hidden" name="id" id="id" value="{{$shop->id}}">
                <div class="form__name">
                    <input type="text" name="name" id="name" placeholder="店舗名" value="{{$shop->name}}">
                    @error('name')
                    <p class="error-message">
                    {{$errors->first('name')}}
                    </p>
                    @enderror
                </div>
                <div class="form__area">                
                    <input type="text" name="area" id="area" placeholder="地域" value="{{$shop->area->name}}">
                    @error('area')
                    <p class="error-message">
                    {{$errors->first('area')}}
                    </p>
                    @enderror
                </div>
                <div class="form__genre">
                    <input type="text" name="genre" id="genre" placeholder="ジャンル" value="{{$shop->genre->name}}">
                    @error('genre')
                    <p class="error-message">
                    {{$errors->first('genre')}}
                    </p>
                    @enderror
                </div>
                <div class="form__description">
                    <textarea name="description" id="description" cols="30" rows="10" placeholder="店舗概要を入力">{{$shop->description}}</textarea>
                    @error('description')
                    <p class="error-message">
                    {{$errors->first('description')}}
                    </p>
                    @enderror
                </div>
                <button type="submit">更新</button>
            </form>
        </div>
    </div>
@endsection