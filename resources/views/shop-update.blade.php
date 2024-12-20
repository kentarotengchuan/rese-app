@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-update.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="box__update">
            <div class="nav">
                <form action="{{ route('back') }}" method="post">
                @csrf
                    <button class="button__nav" type="submit"><</button>
                </form>
                <p class="ttl__create">店舗情報の更新</p>
            </div>
            <div class="img__inner">
                <img class="img__shop" src="{{ asset('storage/shop_images/'.$shop->img_path) }}" alt="">
            </div>           
            <form action=" {{route('update-shop')}} " method="post" enctype="multipart/form-data">
            @csrf
                <input class="input__update" type="hidden" name="id" id="id" value="{{$shop->id}}">
                <div class="form__name">
                    <input class="input__update" type="text" name="name" id="name" placeholder="店舗名" value="{{$shop->name}}">
                    @error('name')
                    <p class="error-message">
                    {{$errors->first('name')}}
                    </p>
                    @enderror
                </div>
                <div class="form__area">                
                    <input class="input__update" type="text" name="area" id="area" placeholder="地域" value="{{$shop->area->name}}">
                    @error('area')
                    <p class="error-message">
                    {{$errors->first('area')}}
                    </p>
                    @enderror
                </div>
                <div class="form__genre">
                    <input class="input__update" type="text" name="genre" id="genre" placeholder="ジャンル" value="{{$shop->genre->name}}">
                    @error('genre')
                    <p class="error-message">
                    {{$errors->first('genre')}}
                    </p>
                    @enderror
                </div>
                <div class="form__description">
                    <textarea class="textarea__update" name="description" id="description" cols="30" rows="10" placeholder="店舗概要を入力">{{$shop->description}}</textarea>
                    @error('description')
                    <p class="error-message">
                    {{$errors->first('description')}}
                    </p>
                    @enderror
                </div>
                <div class="form__img">
                        <input class="input__update-img" type="file" name="image" id="image">
                        @error('image')
                        <p class="error-message">
                        {{$errors->first('image')}}
                        </p>
                        @enderror
                    </div>
                <button class="button__submit" type="submit">更新</button>
            </form>
        </div>
    </div>
@endsection