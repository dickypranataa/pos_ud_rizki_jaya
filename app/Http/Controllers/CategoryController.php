<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function index()
    {
        //halaman index kategori
        // PERBAIKAN: Ambil data dulu dari database!
        $categories = Category::all();
        Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        //halaman create kategori
        return view('categories.create');
    }

    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
        ]);

        //simpan kategori baru
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        //halaman edit kategori
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        //validasi input
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable',
        ]);

        //update kategori
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        //hapus kategori
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }


}
