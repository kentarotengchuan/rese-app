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
                <button type="submit"><</button>
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
                    <button id="openModalButton{{$reservation->id}}">QRコードをスキャン</button>
                </div>
                <!-- モーダル本体 -->
                <div id="qrModal{{$reservation->id}}" class="modal">
                    <div class="modal-content">
                        <span id="closeModalButton{{$reservation->id}}" class="close">&times;</span>
                        <h2>QRコードをスキャン</h2>
                        <video id="video{{$reservation->id}}" autoplay></video>
                    </div>
                </div>
                @endif
                @if($reservation->visited == 'yes')
                <p id="visited_message{{$reservation->id}}" class="visited_message">QRコード照合済み</p>
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
        messageElement{{$reservation->id}}.classList.add(type);  // 'success' または 'error'
        messageElement{{$reservation->id}}.style.display = 'block';

        if (type === 'success') {
            readerElement{{$reservation->id}}.style.display = 'none';
        }
    }

    const modal{{$reservation->id}} = document.getElementById(`qrModal{{$reservation->id}}`);
    const openModalButton{{$reservation->id}} = document.getElementById(`openModalButton{{$reservation->id}}`);
    const closeModalButton{{$reservation->id}} = document.getElementById(`closeModalButton{{$reservation->id}}`);
    const video{{$reservation->id}} = document.getElementById(`video{{$reservation->id}}`);

    // モーダルを開く処理
    openModalButton{{$reservation->id}}.addEventListener('click', () => {
        modal{{$reservation->id}}.style.display = 'flex';
        startCamera{{$reservation->id}}();
    });

    // モーダルを閉じる処理
    closeModalButton{{$reservation->id}}.addEventListener('click', () => {
        modal{{$reservation->id}}.style.display = 'none';
        stopCamera{{$reservation->id}}();
    });

    // カメラを起動する処理
    function startCamera{{$reservation->id}}() {
        const constraints{{$reservation->id}} = {
            video: { facingMode: 'enviroment' } // 背面カメラを使う
        };
        navigator.mediaDevices.getUserMedia(constraints{{$reservation->id}})
            .then((stream) => {
                video{{$reservation->id}}.srcObject = stream;
                requestAnimationFrame(() => scanQRCode{{$reservation->id}}(video{{$reservation->id}})); // QRコードのスキャン開始
            })
            .catch((error) => {
                console.error("カメラの起動に失敗しました:", error);
            });
    }

    // カメラを停止する処理
    function stopCamera{{$reservation->id}}() {
        const stream{{$reservation->id}} = video{{$reservation->id}}.srcObject;
        const tracks{{$reservation->id}} = stream{{$reservation->id}}.getTracks();
        tracks{{$reservation->id}}.forEach(track{{$reservation->id}} => track{{$reservation->id}}.stop());
        video{{$reservation->id}}.srcObject = null;
    }

    // QRコードをスキャンする処理
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
            sendQrData{{$reservation->id}}(qrCode{{$reservation->id}}.data);  // 読み取ったQRコードのデータを送信
            modal{{$reservation->id}}.style.display = 'none'; // QRコードスキャン後にモーダルを閉じる
            stopCamera{{$reservation->id}}();
        } else {
            requestAnimationFrame(() => scanQRCode{{$reservation->id}}(video{{$reservation->id}})); // QRコードが見つかるまで繰り返す
        }
    }

    // QRコードのデータをLaravelに送信する処理
    function sendQrData{{$reservation->id}}(qrCode) {
        const reservationId{{$reservation->id}} = {{$reservation->id}}; // 必要なら予約IDを追加

        fetch('/control/qr-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRFトークン
            },
            body: JSON.stringify({
                qr_code_data: qrCode,
                id: {{$reservation->id}}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showMessage{{$reservation->id}}(data.message, 'success'); // 成功時メッセージを表示
            } else {
                showMessage{{$reservation->id}}(data.message, 'error'); // 失敗時メッセージを表示
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