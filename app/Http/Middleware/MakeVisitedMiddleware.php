<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Reservation;

class MakeVisitedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $endDate = now('Asia/Tokyo')->format("Y-m-d");
        $endTime = now('Asia/Tokyo')->format("H:i:s");
        Reservation::where('visited','no')
        ->where('date','<=',$endDate)
        ->where('time','<=',$endTime)
        ->update(['visited' => 'yes']);
    
        return $next($request);
    }
}
