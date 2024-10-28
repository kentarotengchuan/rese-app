<?php

namespace App\Console\Commands;

use App\Mail\RemindSend;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'remind:send';
    protected $description = '予定のリマインドメールを送るコマンドです';

    public function handle()
    {
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
    }
}
