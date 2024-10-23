@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection
@section('main')
    <div class="content">
        <p class="username">{{$user->name}}さん</p>
        <div class="my-reservations">
            <p class="ttl">予約状況</p>
            @if (session('please_set_later'))
            <p class="error-message">{{ session('please_set_later') }}</p>
            @endif
            @error('date')
            <p class="error-message">
                {{$errors->first('date')}}
            </p>
            @enderror
            @error('time')
            <p class="error-message">
                {{$errors->first('time')}}
            </p>
            @enderror
            @error('number')
            <p class="error-message">
                {{$errors->first('number')}}
            </p>
            @enderror
            @foreach ($not_reviewed_reservations as $reservation)
            <div class="box__reservation">
                <button id="change-button{{$reservation->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </button>
                <p class="iteration">予約{{$loop->iteration}}</p>
                <button id="delete-button{{$reservation->id}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                </button>
                <div id="change-modal{{$reservation->id}}" class="change-modal">
                    <form action="{{ route('change-reservation',['id'=>$reservation->id]) }}" method="post" id="change{{$reservation->id}}">
                    @csrf
                        <input type="date" name="date" id="date" value={{$reservation->date}}>
                        <input type="time" name="time" id="time" value={{$reservation->time}}>
                        <input type="hidden" name="number" value={{$reservation->number}}>
                    </form>
                    <div class="buttons">
                        <button id="close-change-button{{$reservation->id}}" class="close-change-button">キャンセル</button>
                        <button type="submit" form="change{{$reservation->id}}">予定変更</button>
                    </div>
                </div>
                <div id="delete-modal{{$reservation->id}}" class="delete-modal">
                    <form action="{{ route('delete-reservation',['id'=>$reservation->id]) }}" method="post" id="delete{{$reservation->id}}">
                    @csrf
                    </form>
                    <div class="buttons">
                        <button id="close-delete-button{{$reservation->id}}" class="close-delete-button">キャンセル</button>
                        <button type="submit" form="delete{{$reservation->id}}">予定削除</button>
                    </div>
                </div>
                <div class="reservation-info">
                    <table class="table__confirm">
                        <tr>
                            <th>Shop</th>
                            <td>{{$reservation->shop->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="output-date">{{$reservation->date}}</td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td id="output-time">{{$reservation->time}}</td>
                        </tr>
                        <tr>
                            <th>Number</th>
                            <td id="output-number">{{$reservation->number}}</td>
                        </tr>
                    </table>
                    <!--QRコード発行-->
                    
                    <!--来店済み-->
                    @if($reservation->visited == 'yes')
                    <form action="{{ route('go-review',['id'=>$reservation->id]) }}" method="get">
                        <button type="submit" name="from" value="mypage">レビューする</button>
                    </form>
                    @endif
                </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="my-likes">
            <p class="ttl">お気に入り店舗</p>
            <div class="flex">
            @foreach ($user->shops as $shop)
                <div class="box__shop">
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
                            <button type="submit" name="from" value="mypage">詳しく見る</button>
                        </form>
                        <form action="{{ route('like-on-mypage',['id'=>$shop->id]) }}" method="post">
                        @csrf
                            <button type="submit">
                                <span class="heart {{ $shop->likedOrNot(auth()->user())? 'liked' : '' }}">&hearts;</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
    @foreach ($user->reservations as $reservation)
    <script>
        var changeModal{{$reservation->id}} = document.getElementById(`change-modal{{$reservation->id}}`);
        var changeButton{{$reservation->id}} = document.getElementById(`change-button{{$reservation->id}}`);
        var closeChangeButton{{$reservation->id}} = document.getElementById(`close-change-button{{$reservation->id}}`);

        var deleteModal{{$reservation->id}} = document.getElementById(`delete-modal{{$reservation->id}}`);
        var deleteButton{{$reservation->id}} = document.getElementById(`delete-button{{$reservation->id}}`);
        var closeDeleteButton{{$reservation->id}} = document.getElementById(`close-delete-button{{$reservation->id}}`);

        changeButton{{$reservation->id}}.onclick = function() {
            changeModal{{$reservation->id}}.style.display = 'block';
            deleteModal{{$reservation->id}}.style.display = 'none';
        }

        closeChangeButton{{$reservation->id}}.onclick = function() {
            changeModal{{$reservation->id}}.style.display = 'none';
        }

        deleteButton{{$reservation->id}}.onclick = function() {
            deleteModal{{$reservation->id}}.style.display = 'block';
            changeModal{{$reservation->id}}.style.display = 'none';
        }

        closeDeleteButton{{$reservation->id}}.onclick = function() {
            deleteModal{{$reservation->id}}.style.display = 'none';
        }
    </script>
    @endforeach
@endsection