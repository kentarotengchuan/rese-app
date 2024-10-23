<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @yield('css')
    <style>
    .modal {
            display: none; /* 初期状態は非表示 */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin:8px;
            background-color: rgba(0, 0, 0, 0.7); /* 半透明の背景 */
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* 中央に配置 */
            background-color: white;
            padding: 20px;
            border: 1px solid #888;
            width: 100%; /* 幅を調整 */
            height:100%;
            /*max-width: 500px; /* 最大幅を設定 */
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
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
                <li>
                    <a href="{{ action('App\Http\Controllers\ShopController@index') }}">
                        Home
                    </a>
                    
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                    </form>
                </li>
                <li>
                    <a href="{{ action('App\Http\Controllers\ShopController@mypage') }}">
                        Mypage
                    </a>
                </li>
                @if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'owner')
                <li>
                    <a href="{{ route('control') }}">
                        Control
                    </a>
                </li>
                @endif
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