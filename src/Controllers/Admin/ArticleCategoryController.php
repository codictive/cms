<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Models\ArticleCategory;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class ArticleCategoryController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(?ArticleCategory $category = null)
    {
        $categories = ArticleCategory::where('parent_id', $category ? $category->id : null)->orderBy('weight')->orderBy('name')->get();

        return view('admin.article_categories.index', ['category' => $category, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(?ArticleCategory $parent = null)
    {
        return view('admin.article_categories.create', ['parent' => $parent]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ?ArticleCategory $parent = null)
    {
        $request->validate([
            'name'   => 'required',
            'slug'   => 'required|unique:article_categories',
            'weight' => 'required|numeric',
        ]);

        $category = ArticleCategory::create(array_merge($request->all(), ['parent_id' => $parent ? $parent->id : null]));

        return redirect()->route('admin.article_categories.index', $parent)->with('success', "دسته {$category->name} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $category)
    {
        return view('admin.article_categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleCategory $category)
    {
        $request->validate([
            'name'   => 'required',
            'slug'   => ['required', Rule::unique('article_categories')->ignore($category->id)],
            'weight' => 'required|numeric',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.article_categories.index', $category->parent_id)->with('info', "دسته {$category->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.article_categories.index', $category->parent_id)->with('warning', "دسته {$category->name} حذف شد.");
    }
}
