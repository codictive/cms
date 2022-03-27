<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Menu;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class MenuController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::paginate(30);

        return view('admin.menus.index', ['menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'nullable|unique:menus',
        ]);
        $menu = Menu::create($request->all());

        return redirect()->route('admin.menus.index')->with('success', "منوی {$menu->name} ایجاد شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $items = $menu->items()->orderBy('weight')->get();

        return view('admin.menus.show', ['menu' => $menu, 'items' => $items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', ['menu' => $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'slug' => ['required', Rule::unique('menus')->ignore($menu->id)],
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menus.index')->with('info', "منوی {$menu->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('warning', "منوی {$menu->name} حذف شد.");
    }
}
