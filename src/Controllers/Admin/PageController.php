<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Page;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class PageController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'DESC')->paginate(30);

        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug'  => 'required|unique:pages',
            'body'  => 'required',
            'image' => 'nullable|image',
        ]);

        $page            = Page::create($request->all());
        $page->published = $request->has('published');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $page->image = moveFile($request->file('image'), Page::STORAGE_DIR);
        }
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', "صفحه استاتیک {$page->title} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', ['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'slug'  => ['required', Rule::unique('pages')->ignore($page->id)],
            'body'  => 'required',
            'image' => 'nullable|image',
        ]);

        $page->update($request->all());
        $page->published = $request->has('published');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // delete old image.
            $page->removeImage();
            $page->image = moveFile($request->file('image'), Page::STORAGE_DIR);
        }
        $page->save();

        return redirect()->route('admin.pages.index')->with('info', "صفحه استاتیک {$page->title} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->purge();

        return redirect()->route('admin.pages.index')->with('warning', "صفحه استاتیک {$page->title} حذف شد.");
    }
}
