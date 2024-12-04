@extends('auth.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="box__login">
            <div class="box__ttl">
                <p class="ttl__text">Login</p>
            </div>
            <form method="POST" action="{{ route('login') }}" id="login">
            @csrf
                <div class="form__email">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <input type="email" name="email" id="email" placeholder="Email">
                    
                </div>
                @error('email')
                <p class="error-message">
                    {{$errors->first('email')}}
                </p>
                @enderror
                <div class="form__password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-keyhole"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                    <input type="password" name="password" id="password" placeholder="Password">
                    
                </div>
                @error('password')
                <p class="error-message">
                    {{$errors->first('password')}}
                </p>
                @enderror
            </form>
            <div class="button__outer">
                <button type="submit" form="login">ログイン</button>
            </div>
        </div>
    </div>
@endsection