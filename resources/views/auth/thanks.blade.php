@extends('auth.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('css/thanks.css')}}">
@endsection
@section('main')
    <main>
        <div class="content">
            <div class="box__thanks">
                <p class="thanks-message">会員登録ありがとうございます。認証メールをご確認ください。</p>
                <div class="buttons">
                    <form action="{{action('App\Http\Controllers\Auth\AuthenticatedSessionController@store')}}" method="post">
                    @csrf
                        <button class="button__thanks" type="submit">ログインする</button>
                    </form>
                    <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                        <button class="button__thanks" type="submit">認証メールを再送</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection