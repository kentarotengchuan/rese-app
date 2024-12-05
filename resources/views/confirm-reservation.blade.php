@extends('layouts.app-ex')
@section('css')
<link rel="stylesheet" href="{{asset('css/confirm.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('main')
    <div class="content">
        <div class="box__confirm">
            <div class="nav">
                <form action="{{ route('back') }}" method="post">
                @csrf
                <button class="button__nav" type="submit"><</button>
            </form>
                <p class="ttl__create">予約状況の確認</p>
            </div>
            <div id="message" class="message"></div>
            <div class="reservations">
            @foreach($reservations as $reservation)
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
                @if($reservation->visited == 'no')
                <div id="reader{{$reservation->id}}" class="reader">
                    <button class="button__reader" id="openModalButton{{$reservation->id}}">QRコードをスキャン</button>
                </div>

                <div id="qrModal{{$reservation->id}}" class="qrmodal">
                    <div class="qrmodal-content">
                        <span id="closeModalButton{{$reservation->id}}" class="qrclose">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                        <video class="video" id="video{{$reservation->id}}" autoplay></video>
                    </div>
                </div>
                @endif
                @if($reservation->visited == 'yes')
                <div id="visited_message{{$reservation->id}}" class="visited_message">QRコード照合済み</div>
                @endif
            </div>
            @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    @foreach($reservations as $reservation)
    <script>
    function showMessage{{$reservation->id}}(message, type) {
        const messageElement{{$reservation->id}} = document.getElementById(`message`);
        const readerElement{{$reservation->id}} = document.getElementById(`reader{{$reservation->id}}`);
        const visitedElement{{$reservation->id}} = document.getElementById(`visited_message{{$reservation->id}}`);

        messageElement{{$reservation->id}}.textContent = message;
        messageElement{{$reservation->id}}.classList.remove('success', 'error');
        messageElement{{$reservation->id}}.classList.add(type);
        messageElement{{$reservation->id}}.style.display = 'block';

        if (type === 'success') {
            readerElement{{$reservation->id}}.style.display = 'none';
        }
    }

    const modal{{$reservation->id}} = document.getElementById(`qrModal{{$reservation->id}}`);
    const openModalButton{{$reservation->id}} = document.getElementById(`openModalButton{{$reservation->id}}`);
    const closeModalButton{{$reservation->id}} = document.getElementById(`closeModalButton{{$reservation->id}}`);
    const video{{$reservation->id}} = document.getElementById(`video{{$reservation->id}}`);

    openModalButton{{$reservation->id}}.addEventListener('click', () => {
        modal{{$reservation->id}}.style.display = 'flex';
        startCamera{{$reservation->id}}();
    });

    closeModalButton{{$reservation->id}}.addEventListener('click', () => {
        modal{{$reservation->id}}.style.display = 'none';
        stopCamera{{$reservation->id}}();
    });

    function startCamera{{$reservation->id}}() {
        const constraints{{$reservation->id}} = {
            video: { facingMode: 'enviroment' } 
        };
        navigator.mediaDevices.getUserMedia(constraints{{$reservation->id}})
            .then((stream) => {
                video{{$reservation->id}}.srcObject = stream;
                requestAnimationFrame(() => scanQRCode{{$reservation->id}}(video{{$reservation->id}}));
            })
            .catch((error) => {
                console.error("カメラの起動に失敗しました:", error);
            });
    }

    function stopCamera{{$reservation->id}}() {
        const stream{{$reservation->id}} = video{{$reservation->id}}.srcObject;
        const tracks{{$reservation->id}} = stream{{$reservation->id}}.getTracks();
        tracks{{$reservation->id}}.forEach(track{{$reservation->id}} => track{{$reservation->id}}.stop());
        video{{$reservation->id}}.srcObject = null;
    }

    function scanQRCode{{$reservation->id}}(video{{$reservation->id}}) {
        if (video{{$reservation->id}}.videoWidth === 0 || video{{$reservation->id}}.videoHeight === 0) {
            requestAnimationFrame(() => scanQRCode{{$reservation->id}}(video{{$reservation->id}}));
            return; 
            }

        const canvas{{$reservation->id}} = document.createElement('canvas');
        const context{{$reservation->id}} = canvas{{$reservation->id}}.getContext('2d');
        canvas{{$reservation->id}}.width = video{{$reservation->id}}.videoWidth;
        canvas{{$reservation->id}}.height = video{{$reservation->id}}.videoHeight;
        context{{$reservation->id}}.drawImage(video{{$reservation->id}}, 0, 0, canvas{{$reservation->id}}.width, canvas{{$reservation->id}}.height);

        const imageData{{$reservation->id}} = context{{$reservation->id}}.getImageData(0, 0, canvas{{$reservation->id}}.width, canvas{{$reservation->id}}.height);
        const qrCode{{$reservation->id}} = jsQR(imageData{{$reservation->id}}.data, imageData{{$reservation->id}}.width, imageData{{$reservation->id}}.height);

        if (qrCode{{$reservation->id}}) {
            console.log('QRコードのデータ:', qrCode{{$reservation->id}}.data);
            sendQrData{{$reservation->id}}(qrCode{{$reservation->id}}.data);
            modal{{$reservation->id}}.style.display = 'none';
            stopCamera{{$reservation->id}}();
        } else {
            requestAnimationFrame(() => scanQRCode{{$reservation->id}}(video{{$reservation->id}}));
        }
    }

    function sendQrData{{$reservation->id}}(qrCode) {
        const reservationId{{$reservation->id}} = {{$reservation->id}};

        fetch('/control/qr-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                qr_code_data: qrCode,
                id: {{$reservation->id}}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showMessage{{$reservation->id}}(data.message, 'success'); 
            } else {
                showMessage{{$reservation->id}}(data.message, 'error');
            }
            console.log('成功:', data);
        })
        .catch(error => {
            console.error('エラー:', error);
            showMessage{{$reservation->id}}('サーバーエラーが発生しました。', 'error'); 
        });
    }
</script>
    @endforeach
@endsection