<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Slider;
use Codictive\Cms\Models\SliderItem;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Codictive\Cms\Controllers\Controller;

class SliderItemController extends Controller
{
    use RequiresUser;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Slider $slider)
    {
        return view('admin.sliders.items.create', ['slider' => $slider]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Slider $slider)
    {
        $request->validate([
            'image'  => 'required|image',
            'weight' => 'required|numeric',
        ]);

        $file = $request->file('image');
        if (! $file->isValid()) {
            return redirect()->back()->withErrors(['تصویر اسلاید نامعتبر است.']);
        }

        $formData          = request()->all();
        $formData['image'] = moveFile($file, SliderItem::STORAGE_DIR);
        $item              = $slider->items()->create($formData);

        return redirect()->route('admin.sliders.show', $slider->id)->with('success', "اسلاید {$item->caption} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SliderItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider, SliderItem $item)
    {
        return view('admin.sliders.items.edit', ['slider' => $slider, 'item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\SliderItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider, SliderItem $item)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'image'  => 'nullable|image',
        ]);

        $formData = $request->all();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // delete old image.
            $item->removeFile();

            $file              = request()->file('image');
            $formData['image'] = moveFile($file, SliderItem::STORAGE_DIR);
        }
        $item->update($formData);

        return redirect()->route('admin.sliders.show', $slider->id)->with('info', "اسلاید {$item->caption} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SliderItem $item
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider, SliderItem $item)
    {
        if ($item->image) {
            $fn = sprintf('%s/%s', SliderItem::STORAGE_DIR, $item->image);
            if (file_exists($fn)) {
                unlink($fn);
            }
        }
        $item->delete();

        return redirect()->route('admin.sliders.show', $slider->id)->with('warning', "اسلاید {$item->caption} حذف شد.");
    }
}
