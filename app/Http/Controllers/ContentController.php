<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    // Menampilkan semua konten
    public function index()
    {
        $contents = Content::latest()->get();
        return view('admin.contents.index', compact('contents'));
    }

    // Form tambah konten
    public function create()
    {
        return view('admin.contents.create');
    }

    // Simpan konten baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'link' => 'required|url'
        ]);

        // Upload gambar
        $path = $request->file('image')->store('images/contents', 'public');
        $validated['image'] = $path;

        Content::create($validated);

        return redirect()->route('contents_index')->with('success', 'Konten berhasil ditambahkan!');
    }

    // Form edit konten
    public function edit(Content $content)
    {
        return view('admin.contents.edit', compact('content'));
    }

    // Update konten
    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link' => 'required|url'
        ]);

        // Jika ada gambar baru, upload dan ganti
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/contents', 'public');
            $validated['image'] = $path;
        }

        $content->update($validated);

        return redirect()->route('contents_index')->with('success', 'Konten berhasil diperbarui!');
    }

    // Hapus konten
    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('contents_index')->with('success', 'Konten berhasil dihapus!');
    }
}
