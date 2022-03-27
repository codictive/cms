<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Menu;
use Codictive\Cms\Models\MenuItem;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Controllers\Controller;

class MenuItemController extends Controller
{
    use RequiresUser;

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Menu $menu)
    {
        $items = $menu->items()->orderBy('weight')->get();

        return view('admin.menus.items.create', ['menu' => $menu, 'items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu)
    {
        $request->validate([
            'title'     => 'required',
            'path'      => 'required',
            'weight'    => 'required|numeric',
            'parent_id' => 'nullable|exists:menu_items,id',
        ]);

        $menuItem = MenuItem::create($request->all());

        return redirect()->route('admin.menus.show', $menu->id)->with('success', "آیتم منوی {$menuItem->title} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Menu     $menu
     * @param \App\MenuItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu, MenuItem $item)
    {
        $items = $menu->items()->orderBy('weight')->get();

        return view('admin.menus.items.edit', ['menu' => $menu, 'item' => $item, 'items' => $items]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Menu     $menu
     * @param \App\MenuItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu, MenuItem $item)
    {
        $request->validate([
            'title'     => 'required',
            'path'      => 'required',
            'weight'    => 'required|numeric',
            'parent_id' => 'nullable|exists:menu_items,id',
        ]);

        $item->update($request->all());

        return redirect()->route('admin.menus.show', $menu->id)->with('info', "آیتم منوی {$item->title} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Menu     $menu
     * @param \App\MenuItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, MenuItem $item)
    {
        $item->delete();

        return redirect()->route('admin.menus.show', $menu->id)->with('warning', "آیتم منوی {$item->title} حذف شد.");
    }
}
