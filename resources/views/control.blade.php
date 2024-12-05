@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/control.css')}}">
@endsection
@section('main')
    <div class="content">
        <p class="ttl">管理画面</p>
        <p class="message">こんにちは、{{$user->name}}さん(
            @if($user->role->name == 'admin')管理者@endif
            @if($user->role->name == 'owner')店舗代表者@endif
            )
        </p>
        @if(session('success_send'))
        <p class="success_message">{{session('success_send')}}</p>
        @endif
        @if(session('flash_message'))
        <p class="flash_message">
            {{session('flash_message')}}
        </p>
        @endif
        @if($user->role->name == 'admin')
        <div class="control__user">
        <div class="box__create">
            <p class="ttl__create">店舗代表者ユーザーの作成</p>
            <form class="box__form" method="POST" action="{{ route('register-owner') }}" id="register">
            @csrf
                <div class="form__username">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input class="box__input" type="text" name="name" id="name" placeholder="Username">
                    @error('name')
                    <p class="error-message">
                    {{$errors->first('name')}}
                    </p>
                    @enderror
                </div>
                <div class="form__email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input class="box__input" type="email" name="email" id="email" placeholder="Email">
                    @error('email')
                        <p class="error-message">
                        {{$errors->first('email')}}
                        </p>
                    @enderror
                </div>
                <div class="form__password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                    <input class="box__input" type="password" name="password" id="password" placeholder="Password">
                    @error('password')
                    <p class="error-message">
                    {{$errors->first('password')}}
                    </p>
                    @enderror
                </div>
            </form>
            <div class="button__outer">
                <button class="box__button" type="submit" form="register">登録</button>
            </div>
            
        </div>
        <div class="box__send-email">
            <p class="box__ttl">お知らせメールの送信</p>
            <form class="form__email" action="{{ route('send-email') }}" method="post">
            @csrf
                <div class="form__title">
                    <input class="input__email" type="text" name="title" id="title" placeholder="メールのタイトルを入力">
                    @error('title')
                    <p class="error-message">{{$errors->first('title')}}</p>
                    @enderror
                </div>
                <div class="form__content">
                    <textarea class="textarea__email" name="content" id="content" cols="30" rows="10" placeholder="メールの本文を入力"></textarea>
                    @error('content')
                    <p class="error-message">{{$errors->first('content')}}</p>
                    @enderror
                </div>
                <button class="button__email" type="submit">メール送信</button>
            </form>
        </div>
        </div>           
        @endif
        @if($user->role->name == 'owner')
            <div class="box__create">
                <p class="ttl__create">店舗情報の作成</p>
                <form class="box__form" action=" {{route('create-shop')}} " method="post" enctype="multipart/form-data">
                @csrf
                    <div class="form__name">
                        <input class="box__input" type="text" name="name" id="name" placeholder="店舗名">
                        @error('name')
                        <p class="error-message">
                        {{$errors->first('name')}}
                        </p>
                        @enderror
                    </div>
                    <div class="form__area">
                        <input class="box__input" type="text" name="area" id="area" placeholder="地域">
                        @error('area')
                        <p class="error-message">
                        {{$errors->first('area')}}
                        </p>
                         @enderror
                    </div>
                    <div class="form__genre">
                        <input class="box__input" type="text" name="genre" id="genre" placeholder="ジャンル">
                        @error('genre')
                        <p class="error-message">
                        {{$errors->first('genre')}}
                        </p>
                        @enderror
                    </div>
                    <div class="form__description">
                        <textarea class="box__textarea" name="description" id="description" cols="30" rows="10" placeholder="店舗概要を入力"></textarea>
                        @error('description')
                        <p class="error-message">
                        {{$errors->first('description')}}
                        </p>
                        @enderror
                    </div>
                    <div class="form__img">
                        <input class="img__input" type="file" name="image" id="image">
                        @error('image')
                        <p class="error-message">
                        {{$errors->first('image')}}
                        </p>
                        @enderror
                    </div>
                    <button class="box__button" type="submit">作成</button>
                    
                </form>
            </div>
            <div class="box__shops">
                <p class="ttl__shops">作成店舗の一覧</p>
                @foreach ($user->own as $shop)
                <div class="shop-info">
                    <div class="img__inner">
                        <img class="img__shop" src="{{ asset('storage/shop_images/'.$shop->img_path) }}" alt="">
                    </div>
                    <h2 class="ttl__shop">{{$shop->name}}</h2>
                    <div class="tags__shop">
                        <span class="tag">#{{$shop->area->name}}</span>
                        <span class="tag">#{{$shop->genre->name}}</span>
                    </div>
                    <div class="buttons">
                        <form class="form__buttons" action="{{ route('detail',['id'=>$shop->id]) }}" method="get">
                        @csrf
                            <button class="button__buttons" type="submit" name="from" value="control">詳細画面</button>
                        </form>
                        <form class="form__buttons" action=" {{route('go-update',['id'=>$shop->id])}} " method="get">
                            <button class="button__buttons" type="submit" name="from" value="control">店舗更新</button>
                        </form>
                        <form class="form__buttons" action=" {{route('go-confirm',['id'=>$shop->id])}} " method="get">
                            <button class="button__buttons" type="submit" name="from" value="control">予約確認</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection