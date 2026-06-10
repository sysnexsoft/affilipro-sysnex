<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\WebSetting;
use Illuminate\Http\Request;

class WebSettingController extends Controller
{
    public function index(){
        return view('backEnd.auth.setting');
    }
    public function settingsUpdate(Request $request){
        $webSetting = WebSetting::first();
        $input = $request->all();

        if ($request->file('header_logo')){
            if (file_exists($webSetting->header_logo)){
                unlink($webSetting->header_logo);
            }
            $headerLogoImage = $request->file('header_logo');
            $headerLogoImageNewName = rand().'.'.$headerLogoImage->extension();
            $dir = 'uploads/settings/';
            $headerLogoImage->move($dir,$headerLogoImageNewName);
            $input['header_logo'] =  $dir.$headerLogoImageNewName;
        }
        if ($request->file('footer_logo')){

            if (file_exists($webSetting->footer_logo)){
                unlink($webSetting->footer_logo);
            }
            $footerLogoImage = $request->file('footer_logo');
            $footerLogoImageNewName = rand().'.'.$footerLogoImage->extension();
            $dir = 'uploads/settings/';
            $footerLogoImage->move($dir,$footerLogoImageNewName);
            $input['footer_logo'] =  $dir.$footerLogoImageNewName;
        }
        if ($request->file('favicon_logo')){
            if (file_exists($webSetting->favicon_logo)){
                unlink($webSetting->favicon_logo);
            }
            $faviconLogoImage = $request->file('favicon_logo');
            $faviconLogoImageNewName = rand().'.'.$faviconLogoImage->extension();
            $dir = 'uploads/settings/';
            $faviconLogoImage->move($dir,$faviconLogoImageNewName);
            $input['favicon_logo'] =  $dir.$faviconLogoImageNewName;
        }

        $webSetting->update($input);
        return back()->with('success','Settings Update Successfully.');
    }
}
