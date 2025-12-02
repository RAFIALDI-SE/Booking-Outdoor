<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        // Simpan gambar ke folder public/images/products
        $path = $request->file('image')->store('images/products', 'public');
        $validated['image'] = $path;

        Product::create($validated);

        return redirect()->route('products_index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        // Jika ada gambar baru, hapus lama dan upload baru
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products_index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products_index')->with('success', 'Produk berhasil dihapus!');
    }

    public function all_products(Request $request)
    {
        $query = Product::with('category');

        // 🔍 Fitur search berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Filter by kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('name')->paginate(9);
        $categories = \App\Models\Category::all();

        return view('members.product', compact('products', 'categories'));
    }

    // product detail
       public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('members.products_detail', compact('product'));
    }

}