@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/confirm-reservation.css')}}">
@endsection
@section('main')
    <div class="content">
        <div class="box__confirm">
            <div class="nav">
                <form action="{{ route('back') }}" method="post">
                @csrf
                <button type="submit"><</button>
            </form>
                <p class="ttl__create">予約状況の確認</p>
            </div>
            <div class="reservations">
            @foreach($not_visited_reservations as $reservation)
            <div class="box__reservation">
                <p class="iteration">予約{{$loop->iteration}}</p>
                <table class="table__confirm">
                        <tr>
                            <th>User</th>
                            <td>{{$reservation->user->name}}</td>
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
                <div class="reader">
                    
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
    @foreach($not_visited_reservations as $reservation)
    <script>
    
    </script>
    @endforeach
@endsection