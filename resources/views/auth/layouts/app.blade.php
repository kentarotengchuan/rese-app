<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header__inner">
            <button id="menuButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-left"><path d="M15 12H3"/><path d="M17 18H3"/><path d="M21 6H3"/></svg>
            </button>
            <p class="header__ttl">Rese</p>
        </div>
    </header>

    <!-- モーダルメニュー -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <button class="close" id="closeButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <ul>
                <li><a href="{{ action('App\Http\Controllers\Auth\AuthenticatedSessionController@create') }}">Home</a></li>
                <li><a href="{{ action('App\Http\Controllers\Auth\RegisteredUserController@create') }}">Registeration</a></li>
                <li><a href="{{ action('App\Http\Controllers\Auth\AuthenticatedSessionController@create') }}">Login</a></li>
            </ul>
        </div>
    </div>

    @yield('main')

    <script>
        // モーダルの表示/非表示を制御するスクリプト
        var modal = document.getElementById('myModal');
        var menuButton = document.getElementById('menuButton');
        var closeButton = document.getElementById('closeButton');

        // メニューボタンをクリックしたとき
        menuButton.onclick = function() {
            modal.style.display = 'block';
        }

        // 閉じるボタンをクリックしたとき
        closeButton.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>