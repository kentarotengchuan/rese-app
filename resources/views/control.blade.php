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
        @if($user->role->name == 'admin')
        <div class="box__create">
            <p class="ttl__create">店舗代表者ユーザーの作成</p>
            <form method="POST" action="{{ route('register-owner') }}" id="register">
            @csrf
                <div class="form__username">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" name="name" id="name" placeholder="Username">
                    @error('name')
                    <p class="error-message">
                    {{$errors->first('name')}}
                    </p>
                    @enderror
                </div>
                <div class="form__email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input type="email" name="email" id="email" placeholder="Email">
                    @error('email')
                    <p class="error-message">
                    {{$errors->first('email')}}
                    </p>
                    @enderror
                </div>
                <div class="form__password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-keyhole"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                    <input type="password" name="password" id="password" placeholder="Password">
                    @error('password')
                    <p class="error-message">
                    {{$errors->first('password')}}
                    </p>
                    @enderror
                </div>
            </form>
            <div class="button__outer">
                <button type="submit" form="register">登録</button>
            </div>
            @if(session('flash_message'))
            <div class="flash_message">
                {{session('flash_message')}}
            </div>
            @endif
        </div>
        <div class="box__send-email">
            <p class="box__ttl">お知らせメールの送信</p>
            <form action="{{ route('send-email') }}" method="post">
            @csrf
                <div class="form__title">
                    <input type="text" name="title" id="title" placeholder="メールのタイトルを入力">
                    @error('title')
                    <p class="error_message">{{$errors->first('title')}}</p>
                    @enderror
                </div>
                <div class="form__content">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="メールの本文を入力"></textarea>
                    @error('content')
                    <p class="error_message">{{$errors->first('content')}}</p>
                    @enderror
                </div>
                <button type="submit">メール送信</button>
            </form>
        </div>           
        @endif
        @if($user->role->name == 'owner')
        <div class="control__shop">
            <div class="box__create">
                <p class="ttl__create">店舗情報の作成</p>
                <form action=" {{route('create-shop')}} " method="post">
                @csrf
                    <div class="form__name">
                        <input type="text" name="name" id="name" placeholder="店舗名">
                        @error('name')
                        <p class="error-message">
                        {{$errors->first('name')}}
                        </p>
                        @enderror
                    </div>
                    <div class="form__area">
                        <input type="text" name="area" id="area" placeholder="地域">
                        @error('area')
                        <p class="error-message">
                        {{$errors->first('area')}}
                        </p>
                         @enderror
                    </div>
                    <div class="form__genre">
                        <input type="text" name="genre" id="genre" placeholder="ジャンル">
                        @error('genre')
                        <p class="error-message">
                        {{$errors->first('genre')}}
                        </p>
                        @enderror
                    </div>
                    <div class="form__description">
                        <textarea name="description" id="description" cols="30" rows="10" placeholder="店舗概要を入力"></textarea>
                        @error('description')
                        <p class="error-message">
                        {{$errors->first('description')}}
                        </p>
                        @enderror
                    </div>
                    <button type="submit">作成</button>
                </form>
            </div>
            <div class="box__shops">
                <p class="ttl__shops">店舗の一覧</p>
                @foreach ($user->own as $shop)
                <div class="shop-info">
                    <div class="img__inner">
                        <img src="" alt="">
                    </div>
                    <h2 class="ttl__shop">{{$shop->name}}</h2>
                    <div class="tags__shop">
                        <span class="area-tag">#{{$shop->area->name}}</span>
                        <span class="genre-tag">#{{$shop->genre->name}}</span>
                    </div>
                    <div class="buttons">
                        <form action="{{ route('detail',['id'=>$shop->id]) }}" method="get">
                        @csrf
                            <button type="submit" name="from" value="control">詳しく見る</button>
                        </form>
                        <!--店舗情報の更新-->
                        <form action=" {{route('go-update',['id'=>$shop->id])}} " method="get">
                            <button type="submit" name="from" value="control">店舗情報の更新</button>
                        </form>
                        <!--予約情報の確認-->
                        <form action=" {{route('go-confirm',['id'=>$shop->id])}} " method="get">
                            <button type="submit" name="from" value="control">予約情報の確認</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection