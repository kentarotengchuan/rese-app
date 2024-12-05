@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/shop-detail.css')}}">
@endsection
@section('main')
    <div class="content">
    <div class="left">
        <div class="nav">
            <form action="{{ route('back') }}" method="post">
            @csrf
                <button class="button__nav" type="submit"><</button>
            </form>
            <span class="nav__ttl">{{$shop->name}}</span>
        </div>
        <div class="img__inner">
            <img class="img__shop" src="{{ asset('storage/shop_images/'.$shop->img_path) }}" alt="">
        </div>
        <div class="tags__shop">
            <span class="area-tag">#{{$shop->area->name}}</span>
            <span class="genre-tag">#{{$shop->genre->name}}</span>
        </div>
        <div class="description__shop">
            <p class="description-text">{{$shop->description}}</p>
        </div>
    </div>
    <div class="right">
        <div class="form__reservation">         
            <p class="form__ttl">予約</p>
            @if (session('please_set_later'))
            <p class="error-message">{{ session('please_set_later') }}</p>
            @endif
            @error('date')
            <p class="error-message">
                ※{{$errors->first('date')}}
            </p>
            @enderror
            @error('time')
            <p class="error-message">
                ※{{$errors->first('time')}}
            </p>
            @enderror
            @error('number')
            <p class="error-message">
                ※{{$errors->first('number')}}
            </p>
            @enderror
            <form action="{{ route('reserve',['id'=>$shop->id]) }}" method="post" id="reservation">
            @csrf
                <input class="input__reservation" type="date" name="date" id="date">
                <input class="input__reservation-time" type="time" name="time" id="time">
                <select class="select__reservation" name="number" id="number">
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
        </div>
        <div class="button__inner">
            <button class="button__reservation" type="submit" form="reservation">予約する</button>
        </div> 
    </div> 
    </div>
    <div class="box__comments">
        <h2 class="ttl__comments">レビュー</h2>
        @foreach ($shop->reviews as $review)
            <div class="box__comment">
                <p class="username">{{$review->user->name}}</p>
                <p class="rating">★{{$review->rating}}</p>
                <p class="comment">{{$review->content}}</p>
            </div>
        @endforeach
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date').on('input', function() {
                const date = $(this).val(); 
                $('#output-date').text(date);
            });
        });

        $(document).ready(function() {
            $('#time').on('input', function() {
                const time = $(this).val(); 
                $('#output-time').text(time); 
            });
        });

        $(document).ready(function() {
                const number = $(this).val(); 
                $('#output-number').text('1人'); 
            });

        $(document).ready(function() {
            $('#number').on('input',function(){
                const number = $(this).val(); 
                $('#output-number').text(number); 
            });
        });
    </script>
@endsection