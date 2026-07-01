<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ImageUpload;
use App\Helpers\SeoHelper;
use App\Http\Controllers\Controller;
use App\Models\SeoGlobal;
use App\Models\SeoManagement;
use Illuminate\Http\Request;

class SeoManagementController extends Controller
{
    // সব পেজের লিস্ট (অ্যাডমিন ড্যাশবোর্ড)
    public function index()
    {
        $pages = \App\Models\SeoManagement::orderBy('id', 'desc')->paginate(20);
        $global = \App\Models\SeoGlobal::firstOrCreate(['id' => 1]);
        return view('backEnd.seo.index', compact('pages', 'global'));
    }

    // পেজ এসইও এডিট ফরম
    public function editPage($id)
    {
        $page = SeoManagement::findOrFail($id);
        return view('backEnd.seo.edit', compact('page'));
    }

    // পেজ এসইও আপডেট
    public function updatePage(Request $request, $id)
    {
        $page = SeoManagement::findOrFail($id);
        $data = $request->except(['meta_image','service']);

        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = ImageUpload::upload($request->file('meta_image'),'uploads/seo',null,null,$page->meta_image);
        }
        $page->update($data);
        if ($request->service){
            return back()->with('success', 'Page SEO configuration updated!');
        }
        return redirect()->route('admin.seo.index')->with('success', 'Page SEO configuration updated!');
    }

    // গ্লোবাল স্ক্রিপ্ট ও Robots.txt আপডেট
    public function updateGlobal(Request $request)
    {
        $global = SeoGlobal::firstOrCreate(['id' => 1]);
        $global->update([
            'robots_txt' => $request->robots_txt,
            'header_scripts' => $request->header_scripts,
            'footer_scripts' => $request->footer_scripts,
        ]);

        // public/robots.txt ফাইলটি সরাসরি ডাইনামিকলি রাইট করা
        File::put(public_path('robots.txt'), $request->robots_txt);

        return redirect()->back()->with('success', 'Global SEO & Robots.txt updated successfully.');
    }

    public function storeCustomPage(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => 'required|string|unique:seo_management,page_slug|max:255',
        ]);
        SeoHelper::generateAutoSeo(null, $request, 'Custom');

        return redirect()->back()->with('success', 'New Custom Page layout registered successfully!');
    }
}
