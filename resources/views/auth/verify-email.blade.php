@extends('auth.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
@endsection
@section('main')
    <main>
        <div class="content">
            <div class="box__thanks">
                <p class="thaks-message">メール認証が済んでいません。認証メールをご確認ください。</p>
                <div class="buttons">
                    <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                        <button type="submit">認証メールを再送</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
