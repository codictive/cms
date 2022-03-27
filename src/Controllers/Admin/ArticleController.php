<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Article;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Models\ArticleCategory;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class ArticleController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Article::orderBy('id', 'DESC')->paginate(30);
        if ($request->query('query')) {
            $articles = $articles->where('query', 'LIKE', "%{$request->query('query')}%");
        }

        return view('admin.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::where('parent_id', null)->orderBy('weight')->orderBy('name')->get();

        return view('admin.articles.create', ['categories' => $categories]);
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
            'slug'  => 'required|unique:articles',
            'body'  => 'required',
            'image' => 'required|image',
        ]);

        $article                      = Article::create($request->all());
        $article->article_category_id = $request->input('category_id');
        $article->published           = $request->has('published');
        $article->promote_to_homepage = $request->has('promote_to_homepage');
        $article->stick_to_top        = $request->has('stick_to_top');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $article->image = moveFile($request->file('image'), Article::STORAGE_DIR);
        }
        $article->save();

        // Process Tags.
        if ($request->input('tags') != null) {
            foreach (explode("\n", $request->input('tags')) as $tag) {
                $tag = trim($tag);
                if ('' == $tag) {
                    continue;
                }

                $t = findOrCreateTag($tag);
                $article->tags()->attach($t->id);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', "مقاله {$article->title} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = ArticleCategory::where('parent_id', null)->orderBy('weight')->orderBy('name')->get();

        return view('admin.articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'slug'  => ['required', Rule::unique('articles')->ignore($article->id)],
            'body'  => 'required',
            'image' => 'nullable|image',
        ]);

        $article->update($request->all());
        $article->article_category_id = $request->input('category_id');
        $article->published           = $request->has('published');
        $article->promote_to_homepage = $request->has('promote_to_homepage');
        $article->stick_to_top        = $request->has('stick_to_top');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // delete old image.
            $article->removeImage();

            $article->image = moveFile($request->file('image'), Article::STORAGE_DIR);
        }
        $article->save();

        // Process Tags.
        $article->tags()->detach();
        if ($request->input('tags') !== null) {
            foreach (explode("\n", $request->input('tags')) as $tag) {
                $tag = trim($tag);
                if ('' == $tag) {
                    continue;
                }

                $t = findOrCreateTag($tag);
                $article->tags()->attach($t->id);
            }
        }

        return redirect()->route('admin.articles.index')->with('info', "مقاله {$article->title} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Article $article
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->purge();

        return redirect()->route('admin.articles.index')->with('warning', "مقاله {$article->title} حذف شد.");
    }
}
