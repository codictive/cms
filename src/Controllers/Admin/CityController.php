<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Codictive\Cms\Models\City;
use Codictive\Cms\Models\Province;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class CityController extends Controller
{
    use RequiresUser;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Province $province)
    {
        return view('cms::admin.cities.create', ['province' => $province]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Province $province)
    {
        $request->validate([
            'name'   => 'required',
            'weight' => 'required|numeric',
        ]);

        $city = $province->cities()->create($request->all());

        return redirect()->route('admin.provinces.show', $province->id)->with('success', "شهر {$city->name} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province, City $city)
    {
        return view('cms::admin.cities.edit', ['province' => $province, 'city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province, City $city)
    {
        $request->validate([
            'name'   => 'required',
            'weight' => 'required|numeric',
        ]);

        $city->update($request->all());

        return redirect()->route('admin.provinces.show', $province->id)->with('info', "شهر {$city->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province, City $city)
    {
        $city->delete();

        return redirect()->route('admin.provinces.show', $province->id)->with('warning', "شهر {$city->name} حذف شد.");
    }
}
