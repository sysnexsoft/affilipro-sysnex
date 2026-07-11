<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use Illuminate\Http\Request;

class PageSettingController extends Controller
{
    // পেজ সেটিংস ভিউ দেখানো
    public function index()
    {
        // ডাটাবেজের প্রথম রোর ডেটা নিয়ে আসা (না থাকলে ফাকা অবজেক্ট দিবে)
        $setting = PageSetting::first();
        return view('backEnd.settings.page_setting', compact('setting'));
    }

    // ডেটা সেভ বা আপডেট করা
    public function update(Request $request)
    {
        // ১. About Us এর সব ইনপুট ডেটা নিয়ে ১টি স্ট্রাকচার্ড অ্যারে তৈরি
        $aboutData = [
            'hero_badge'   => $request->about_hero_badge,
            'hero_title'   => $request->about_hero_title,
            'hero_desc'    => $request->about_hero_desc,
            'stat1_val'    => $request->about_stat1_val,
            'stat1_lbl'    => $request->about_stat1_lbl,
            'stat2_val'    => $request->about_stat2_val,
            'stat2_lbl'    => $request->about_stat2_lbl,
            'stat3_val'    => $request->about_stat3_val,
            'stat3_lbl'    => $request->about_stat3_lbl,
            'feat_title'   => $request->about_feat_title,
            'f1_title'     => $request->about_f1_title,
            'f1_desc'      => $request->about_f1_desc,
            'f2_title'     => $request->about_f2_title,
            'f2_desc'      => $request->about_f2_desc,
            'f3_title'     => $request->about_f3_title,
            'f3_desc'      => $request->about_f3_desc,
            'quote_text'   => $request->about_quote_text,
            'quote_author' => $request->about_quote_author,
        ];

        // ২. ডাটাবেজে ডাটা সংরক্ষণ
        \App\Models\PageSetting::updateOrCreate(
            ['id' => 1],
            [
                'about_us'             => json_encode($aboutData), // JSON কনভার্ট
                'privacy_policy'       => $request->privacy_policy,
                'terms_conditions'     => $request->terms_conditions,
                'disclosure'           => $request->disclosure,
                'affiliate_disclosure' => $request->affiliate_disclosure,
                'disclaimer'           => $request->disclaimer,
                'contact_info'         => $request->contact_info,
                'cookie_policy'        => $request->cookie_policy,
            ]
        );

        return redirect()->back()->with('success', 'Page Settings updated successfully!');
    }
}
