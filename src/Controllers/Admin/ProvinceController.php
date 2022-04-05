<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Models\Province;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class ProvinceController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::orderBy('weight')->orderBy('name')->get();

        return view('cms::admin.provinces.index', ['provinces' => $provinces]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::admin.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|unique:provinces',
            'weight' => 'required|numeric',
        ]);

        $province = Province::create($request->all());

        return redirect()->route('admin.provinces.index')->with('success', "استان {$province->name} ایجاد شد.");
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        $cities = $province->cities()->orderBy('weight')->orderBy('name')->get();

        return view('cms::admin.provinces.show', ['province' => $province, 'cities' => $cities]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        return view('cms::admin.provinces.edit', ['province' => $province]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name'   => ['required', Rule::unique('provinces')->ignore($province->id)],
            'weight' => 'required|numeric',
        ]);

        $province->update($request->all());

        return redirect()->route('admin.provinces.index')->with('info', "استان {$province->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        $province->delete();

        return redirect()->route('admin.provinces.index')->with('warning', "استان {$province->name} حذف شد.");
    }
}
