<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/thanks',[RegisteredUserController::class,'thanks'])->name('thanks');

Route::middleware(['auth','verified'])->
group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/',[ShopController::class,'index'])->name('index');
    Route::post('/like/{id}',[ShopController::class,'like'])->name('like');
    Route::get('/control',[ShopController::class,'control'])->name('control');

    Route::get('/detail/{id}',[ShopController::class,'detail'])->name('detail');
    Route::post('/back',[ShopController::class,'back'])->name('back');
    Route::post('/detail/{id}/reserve',[ShopController::class,'reserve'])->name('reserve');


    Route::get('mypage',[ShopController::class,'mypage'])->name('mypage');
    Route::post('mypage/change-reservation/{id}',[ShopController::class,'change'])->name('change-reservation');
    Route::post('mypage/delete-reservation/{id}',[ShopController::class,'delete'])->name('delete-reservation');
    Route::post('mypage/like/{id}',[ShopController::class,'likeOnMypage'])->name('like-on-mypage');

    Route::get('mypage/payment/{id}',[ShopController::class,'goPayment'])->name('go-payment');
    Route::post('mypage/payment/checkout', [ShopController::class, 'payment'])->name('payment.session');
    Route::get('/payment/success', [ShopController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [ShopController::class, 'cancel'])->name('payment.cancel');

    Route::get('mypage/review/{id}',[ShopController::class,'goReview'])->name('go-review');
    Route::post('mypage/review/post',[ShopController::class,'review'])->name('review');

    Route::post('/control/create',[ShopController::class,'create'])->name('create-shop');
    Route::get('/control/update/{id}',[ShopController::class,'goUpdate'])->name('go-update');
    Route::post('/control/updated',[ShopController::class,'update'])->name('update-shop');
    Route::get('/control/confirm-reservation/{id}',[ShopController::class,'goConfirm'])->name('go-confirm');
    Route::post('/control/send-email',[ShopController::class,'send'])->name('send-email');
    Route::post('/control/qr-code', [ShopController::class, 'sendQR']);
});

require __DIR__.'/auth.php';
