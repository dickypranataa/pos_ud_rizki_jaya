<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    //TAMBAH BARANG

    public function create(){
        //  membutuhkan data kategori
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'category_id' => 'required',
            'unit' => 'required',
            'stock' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'price_retail' => 'required|numeric',
            'price_semi_wholesale' => 'required|numeric',
            'price_wholesale' => 'required|numeric',
        ]);

        // Simpan ke Database
        Product::create($request->all());

        // Redirect kembali ke halaman Index (Daftar)
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    //EDIT BARANG
    public function edit(Product $product)
    {
        $categories = Category::all();

        // Variable $product sudah otomatis tersedia berkat (Product $product) di atas
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) // Gunakan Type Hint 'Product'
    {
        // Validasi input
        $request->validate([
            // Perbaikan pada unique validation: abaikan ID produk ini sendiri
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required',
            'category_id' => 'required',
            'unit' => 'required',
            'stock' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'price_retail' => 'required|numeric',
            'price_semi_wholesale' => 'required|numeric',
            'price_wholesale' => 'required|numeric',
        ]);

        // Update di Database (Tidak perlu findOrFail lagi)
        $product->update($request->all());

        // Redirect kembali ke halaman Index (Daftar)
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    //HAPUS BARANG
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

}
