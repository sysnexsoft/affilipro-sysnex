<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClickLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
    public function trafficLogs()
    {
        $logs = ClickLog::latest()->paginate(50);
        return view('backEnd.logs.clicks', compact('logs'));
    }
    public function performanceReports(Request $request)
    {
        // ১. ফিল্টারিং লজিক (যা আগে ছিল)
        $filter = $request->get('filter', 'today');
        $query = ClickLog::query();

        if ($filter == 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'yesterday') {
            $query->whereDate('created_at', Carbon::yesterday());
        } elseif ($filter == 'last_7_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($filter == 'last_30_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        // সব লগ সংগ্রহ (লজিক প্রসেস করার জন্য)
        $logs = $query->get();

        // বট ফিল্টারিং লজিক (নতুন)
        $botPatterns = ['bot', 'crawler', 'spider', 'curl', 'python', 'googlebot', 'bingbot', 'slurp', 'yandex', 'headless'];

        $realVisitorsData = $logs->filter(fn($log) => !Str::contains(strtolower($log->user_agent), $botPatterns));
        $fakeVisitorsData = $logs->filter(fn($log) => Str::contains(strtolower($log->user_agent), $botPatterns));

        // ক) কাউন্টার উইজেটস (আগের লজিক + রিয়েল/ফেক আপডেট)
        $totalRealClicks = $realVisitorsData->count();
        $totalFakeClicks = $fakeVisitorsData->count();
        $totalClicks = $logs->count(); // আগের টোটাল ক্লিকস
        $uniqueVisitors = $realVisitorsData->pluck('ip_address')->unique()->count();

        // আগের বাউন্স রেট লজিক (রিয়েল ডাটার ওপর)
        $bounceRateEstimate = $uniqueVisitors > 0
            ? round(($realVisitorsData->groupBy('ip_address')->filter(fn($g) => $g->count() == 1)->count() / $uniqueVisitors) * 100, 1)
            : 0;

        $topPages = $realVisitorsData->groupBy('url')->map(function ($items, $url) {
            return (object) [
                'url' => $url,
                'total' => $items->count()
            ];
        })->sortByDesc('total')->take(10);

        $topReferrers = $realVisitorsData->groupBy('referrer')->map(function ($items, $referrer) {
            return (object) [
                'referrer' => $referrer,
                'total' => $items->count()
            ];
        })->sortByDesc('total')->take(10);

        $deviceData = $realVisitorsData->groupBy('device')->map(function ($items, $device) {
            return (object) [
                'device' => $device,
                'total' => $items->count()
            ];
        })->values();

        $browserData = $realVisitorsData->groupBy('browser')->map(function ($items, $browser) {
            return (object) [
                'browser' => $browser,
                'total' => $items->count()
            ];
        })->sortByDesc('total')->values();

        // কান্ট্রি ব্রেকডাউন
        $countryData = $realVisitorsData->groupBy('country')->map(function ($items, $country) {
            return (object) ['country' => $country, 'total' => $items->count()];
        })->sortByDesc('total');

        // ছ) Hourly Traffic Trend (আগের লজিক - ২৪ ঘণ্টার ট্রেন্ড)
        $hourlyData = $realVisitorsData->groupBy(fn($l) => Carbon::parse($l->created_at)->format('H'))->map->count();
        $hourlyTicks = array_map(fn($i) => $hourlyData->get(str_pad($i, 2, '0', STR_PAD_LEFT), 0), range(0, 23));

        // সার্চ ইঞ্জিনের একটি তালিকা
        $searchEngines = ['google', 'bing', 'yahoo', 'duckduckgo', 'baidu', 'yandex'];
        // অর্গানিক ট্রাফিক আলাদা করা
        $organicTrafficData = $realVisitorsData->filter(function($log) use ($searchEngines) {
            if (!$log->referrer) return false;
            foreach ($searchEngines as $engine) {
                if (Str::contains(strtolower($log->referrer), $engine)) {
                    return true;
                }
            }
            return false;
        });

        $totalOrganicClicks = $organicTrafficData->count();
        // ভিউতে সব পাঠানো হলো
        return view('backEnd.logs.reports', compact(
            'totalClicks', 'totalRealClicks', 'totalFakeClicks', 'uniqueVisitors', 'bounceRateEstimate',
            'topPages', 'topReferrers', 'deviceData', 'browserData', 'countryData', 'hourlyTicks', 'filter','totalOrganicClicks'
        ));
    }
}
