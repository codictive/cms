<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Models\Slider;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class SliderController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();

        return view('cms::admin.sliders.index', ['sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::admin.sliders.create');
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
            'slug' => 'required|unique:sliders',
        ]);

        $slider = Slider::create($request->all());

        return redirect()->route('admin.sliders.index')->with('success', "اسلایدر {$slider->name} ایجاد شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Slider $slider
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        $items = $slider->items()->orderBy('weight')->get();

        return view('cms::admin.sliders.show', ['slider' => $slider, 'items' => $items]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Slider $slider
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('cms::admin.sliders.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Slider $slider
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'name' => 'required',
            'slug' => ['required', Rule::unique('sliders')->ignore($slider->id)],
        ]);

        $slider->update($request->all());

        return redirect()->route('admin.sliders.index')->with('info', "اسلایدر {$slider->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Slider $slider
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->purge();

        return redirect()->route('admin.sliders.index')->with('warning', "اسلایدر {$slider->name} حذف شد.");
    }
}
