@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/payment.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('main')
<div class="content">
    <div class="nav">
        <form action="{{ route('back') }}" method="post">
        @csrf
            <button type="submit"><</button>
        </form>
        <h2 class="ttl">Stripe決済</h2>
    </div>
    <div id="message" class="message"></div>
    <div class="box__payment">
        <div class="box__ttl">
            <p class="text__ttl"id="shop-name">{{$reservation->shop->name}}</p>
        </div>
        <div class="form__review">
            <form id="payment">
               <label for="amount">金額(円):</label>
               <input type="number" id="amount" name="amount" min="1" required>
            </form>
            <div class="button__inner">
            <button type="button" form="payment" id="payment-button">支払う</button>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Stripeの公開キーを使用
        const stripe = Stripe(`{{ env('STRIPE_KEY') }}`);

        document.getElementById('payment-button').addEventListener('click', function () {
            const amount = document.getElementById('amount').value;
            const name = `{{$reservation->shop->name}}`;

            fetch('/mypage/payment/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    amount: amount,
                    name: name,
                })
            })
            .then(response => response.json())
            .then(session => {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .catch(error => {
                console.error('エラー:', error);
            });
        });
    </script>
</div>
@endsection