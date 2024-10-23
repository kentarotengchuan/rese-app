@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-detail.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="nav">
            <form action="{{ route('back') }}" method="post">
            @csrf
                <button type="submit"><</button>
            </form>
            <span class="nav__ttl">{{$shop->name}}</span>
        </div>
        <div class="img__inner">
            <img src="" alt="">
        </div>
        <div class="tags__shop">
            <span class="area-tag">#{{$shop->area->name}}</span>
            <span class="genre-tag">#{{$shop->genre->name}}</span>
        </div>
        <div class="description__shop">
            <p class="description-text">{{$shop->description}}</p>
        </div>
        <div class="form__reservation">         
            <p class="form__ttl">予約</p>
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
            <form action="{{ route('reserve',['id'=>$shop->id]) }}" method="post" id="reservation">
            @csrf
                <input type="date" name="date" id="date">
                <input type="time" name="time" id="time">
                <select name="number" id="number">
                    <option value="1人" selected>1人</option>
                    <option value="2人">2人</option>
                    <option value="3人">3人</option>
                    <option value="4人">4人</option>
                    <option value="5人">5人</option>
                    <option value="6人">6人</option>
                </select>
            </form>
            <div class="confirm">
                <table class="table__confirm">
                    <tr>
                        <th>Shop</th>
                        <td>{{$shop->name}}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td id="output-date"></td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td id="output-time"></td>
                    </tr>
                    <tr>
                        <th>Number</th>
                        <td id="output-number"></td>
                    </tr>
                </table>
            </div>
            <div class="button__inner">
                <button type="submit" form="reservation">予約する</button>
            </div>
        </div>  
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date').on('input', function() {
                const date = $(this).val(); // 入力内容を取得
                $('#output-date').text(date); // 表示エリアに反映
            });
        });

        $(document).ready(function() {
            $('#time').on('input', function() {
                const time = $(this).val(); // 入力内容を取得
                $('#output-time').text(time); // 表示エリアに反映
            });
        });

        $(document).ready(function() {
                const number = $(this).val(); // 入力内容を取得
                $('#output-number').text('1人'); // 表示エリアに反映
            });

        $(document).ready(function() {
            $('#number').on('input',function(){
                const number = $(this).val(); // 入力内容を取得
                $('#output-number').text(number); // 表示エリアに反映
            });
        });
    </script>
@endsection