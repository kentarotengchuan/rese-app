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
<body class="body">
    <header class="header">
        <div class="header__inner">
            <button class="menu-button" id="menuButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-left"><path d="M15 12H3"/><path d="M17 18H3"/><path d="M21 6H3"/></svg>
            </button>
            <p class="header__ttl">Rese</p>
        </div>
        <div class="form__search">
        <form class="search" action="{{route('index')}}" method="get">
            <select class="select" name="area" id="area" onchange="this.form.submit()">
                <option value="all">All area</option>
                @foreach ($areas as $area)
                <option value="{{$area->id}}" {{request('area') == $area->id ? 'selected' : ''}}>
                    {{$area->name}}
                </option>
                @endforeach
            </select>
            <select class="select" name="genre" id="genre" onchange="this.form.submit()">
                <option value="all">All genre</option>
                @foreach ($genres as $genre)
                <option value="{{$genre->id}}" {{request('genre') == $genre->id ? 'selected' : ''}}>
                    {{$genre->name}}
                </option>
                @endforeach
            </select>
            <input class="input" type="text" name="search" id="search" value="{{ request('search') }}" placeholder="🔍Search…">
        </form>
    </div>
    </header>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <button class="close" id="closeButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <ul class="modal-ul">
                <li class="modal-li">
                    <a class="modal-link" href="{{ action('App\Http\Controllers\ShopController@index') }}">
                        Home
                    </a>
                    
                </li>
                <li class="modal-li">
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="modal-logout-button" type="submit">Logout</button>
                    </form>
                </li>
                <li class="modal-li">
                    <a class="modal-link" href="{{ action('App\Http\Controllers\ShopController@mypage') }}">
                        Mypage
                    </a>
                </li>
                @if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'owner')
                <li class="modal-li">
                    <a class="modal-link" href="{{ route('control') }}">
                        Control
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    @yield('main')

    <script>
        var modal = document.getElementById('myModal');
        var menuButton = document.getElementById('menuButton');
        var closeButton = document.getElementById('closeButton');

        menuButton.onclick = function() {
            modal.style.display = 'block';
        }

        closeButton.onclick = function() {
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
