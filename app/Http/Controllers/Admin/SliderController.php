<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->orderByDesc('id')->get();
        return view('Admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('Admin.slider.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['image'] = $request->file('image')->store('sliders', 'public');
        $data['status'] = $request->boolean('status');

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('Admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $this->validateData($request, true);
        $data['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted.');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['status' => !$slider->status]);
        return back()->with('success', 'Slider status updated.');
    }

    protected function validateData(Request $request, bool $imageOptional = false): array
    {
        return $request->validate([
            'badge'       => 'nullable|string|max:100',
            'badge_icon'  => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'image'       => ($imageOptional ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:4096',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
