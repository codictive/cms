<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Tag;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class TagController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(50);

        return view('admin.tags.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:tags', 'slug' => 'nullable|unique:tags']);
        $tag = Tag::create($request->all());

        return redirect()->route('admin.tags.index')->with('success', "برچسب {$tag->name} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', ['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => ['required', Rule::unique('tags')->ignore($tag->id)],
            'slug' => ['nullable', Rule::unique('tags')->ignore($tag->id)],
        ]);

        $tag->update($request->all());

        return redirect()->route('admin.tags.index')->with('info', "برچسب {$tag->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('warning', "برچسب {$tag->name} حذف شد.");
    }
}
