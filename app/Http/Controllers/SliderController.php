<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    // Tampilkan semua slider
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    // Form tambah slider
    public function create()
    {
        return view('admin.sliders.create');
    }

    // Simpan slider baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        // upload file
        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'link' => $request->link,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('slider_index')->with('success', 'Slider berhasil ditambahkan.');
    }

    // Form edit slider
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    // Update slider
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['title', 'subtitle', 'link', 'is_active']);

        // jika ada gambar baru
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('slider_index')->with('success', 'Slider berhasil diperbarui.');
    }

    // Hapus slider
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('slider_index')->with('success', 'Slider berhasil dihapus.');
    }
}
