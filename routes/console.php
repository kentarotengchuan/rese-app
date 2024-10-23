<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Mail\RemindSend;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*Artisan::command('remind:send',function(){
    $today = Carbon::today()->format('Y-m-d');

    $reservations = Reservation::where('date', $today)
        ->where('reminded', 'no')
        ->with('user')
        ->get();

    foreach ($reservations as $reservation) {
        Mail::to($reservation->user->email)->send(new RemindSend($reservation));
        $reservation->update(['reminded' => 'yes']);
    }

    $this->info('リマインダーが送信されました。');
})->purpose('予定のリマインドメールを送信するコマンドです');

/*Schedule::command('remind:send',function(){
    $today = Carbon::today();

    $reservations = Reservation::where('date', $today)
        ->where('reminded', 'no')
        ->with('user')
        ->get();

    foreach ($reservations as $reservation) {
        Mail::to($reservation->user->email)->send(new RemindSend($reservation));
        $reservation->update(['reminded' => 'yes']);
    }

    $this->info('リマインダーが送信されました。');
})->purpose('予定のリマインドメールを送信するコマンドです')->dailyAt('17:05');*/

//Schedule::command('remind:send')->dailyAt('17:57');

Schedule::call(function(){
    $today = Carbon::today()->format('Y-m-d');

    $reservations = Reservation::where('date', $today)
        ->where('reminded', 'no')
        ->with('user')
        ->get();

    foreach ($reservations as $reservation) {
        Mail::to($reservation->user->email)->send(new RemindSend($reservation));
        $reservation->update(['reminded' => 'no']);
    }

    $this->info('リマインダーが送信されました。');
})->everyMinute();//->daily('08:50');
