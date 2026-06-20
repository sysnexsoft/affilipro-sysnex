<?php

namespace App\Http\Middleware;

use App\Models\ClickLog;
use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class TrackClickLog
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && !$request->is('admin*') && !$request->ajax()) {
            $userAgent = $request->header('User-Agent');
            $ip = $request->ip();
            if ($ip == '127.0.0.1' || $ip == '::1') {
                $ip = '103.230.104.1';
            }

            // 🌍 রিয়েল কান্ট্রি ট্র্যাকিং লজিক
            $country = 'Unknown';
            if ($position = Location::get($ip)) {
                $country = $position->countryName; // যেমন: Bangladesh, United States
            }

            // 📱 ডিভাইস ডিটেকশন
            $device = 'Desktop';
            if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent)) {
                $device = 'Mobile';
            } elseif (preg_match('/(ipad|tablet|(android(?!.*mobile))无需)/i', $userAgent)) {
                $device = 'Tablet';
            }

            // 🌐 ব্রাউজার ডিটেকশন
            $browser = 'Unknown Browser';
            if (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
            elseif (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
            elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
            elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';

            // ডেটাবেজে রিয়েল ডেটা ইনসার্ট
            ClickLog::create([
                'url'        => $request->fullUrl(),
                'ip_address' => $request->ip(), // এখানে ইউজারের অরিজিনাল আইপি-ই সেভ হবে
                'country'    => $country,       // এখানে রিয়েল কান্ট্রি নেম সেভ হবে
                'device'     => $device,
                'browser'    => $browser,
                'referrer'   => $request->headers->get('referer') ? parse_url($request->headers->get('referer'), PHP_URL_HOST) : 'Direct Visit',
            ]);
        }

        return $next($request);
    }
}
