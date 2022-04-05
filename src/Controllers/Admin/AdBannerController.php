<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Models\AdBanner;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class AdBannerController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = AdBanner::all();

        return view('cms::admin.banners.index', ['banners' => $banners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:ad_banners',
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        if (! $file || ! $file->isValid()) {
            return redirect()->back()->withErrors(['پرونده آپلود شده نامعتبر است.']);
        }

        $size   = $file->getSize();
        $mime   = $file->getMimeType();
        $banner = AdBanner::create([
            'name'      => $request->input('name'),
            'link'      => $request->input('link'),
            'file_name' => moveFile($file, AdBanner::STORAGE_DIR),
            'kind'      => explode('/', $mime)[0],
            'mimetype'  => $mime,
            'size'      => $size,
        ]);

        return redirect()->route('admin.ad_banners.index')->with('success', "بنر {$banner->name} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(AdBanner $banner)
    {
        return view('cms::admin.banners.edit', ['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdBanner $banner)
    {
        $request->validate([
            'name' => ['required', Rule::unique('ad_banners')->ignore($banner->id)],
            'file' => 'nullable|file',
        ]);

        $banner->name = $request->input('name');
        $banner->link = $request->input('link');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if (! $file || ! $file->isValid()) {
                return redirect()->back()->withErrors(['پرونده آپلود شده نامعتبر است.']);
            }

            // Remove old file.
            $banner->removeFile();

            $size              = $file->getSize();
            $mime              = $file->getMimeType();
            $banner->file_name = moveFile($file, AdBanner::STORAGE_DIR);
            $banner->kind      = explode('/', $mime)[0];
            $banner->mimetype  = $mime;
            $banner->size      = $size;
        }

        $banner->save();

        return redirect()->route('admin.ad_banners.index')->with('info', "بنر تبلیغاتی {$banner->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdBanner $banner)
    {
        $banner->purge();

        return redirect()->route('admin.ad_banners.index')->with('warning', "بنر تبلیغاتی {$banner->name} حذف شد.");
    }
}
