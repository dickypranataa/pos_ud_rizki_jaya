<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CustomerType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class PosPage extends Component
{
    // --- PROPERTI DATA ---
    public $search = ''; // Untuk kolom pencarian
    public $cart = []; // Keranjang belanja (Array)

    // --- PILIHAN HARGA ---
    public $priceTypes = [];
    public $selectedPriceTypeId = null; // ID Tipe Harga yang dipilih (1, 2, atau 3)

    // --- PEMBAYARAN ---
    public $paymentAmount = 0; // Uang yang dibayar
    public $paymentMethod = 'Tunai';

    public function mount()
    {
        // Ambil data tipe harga untuk tombol pilihan
        $this->priceTypes = CustomerType::all();
    }

    // --- LOGIKA UTAMA ---

    // 1. Memilih Tipe Harga (Kunci Sesi)
    public function selectPriceType($typeId)
    {
        // Jika keranjang masih ada isinya, peringatkan kasir
        if (count($this->cart) > 0) {
            // Opsional: Anda bisa reset keranjang jika tipe harga berubah
            $this->cart = [];
        }
        $this->selectedPriceTypeId = $typeId;
    }

    // 2. Menambah Barang ke Keranjang
    public function addToCart($productId)
    {
        // Validasi: Harus pilih tipe harga dulu!
        if (!$this->selectedPriceTypeId) {
            session()->flash('error', 'Harap pilih Tipe Harga terlebih dahulu!');
            return;
        }

        $product = Product::find($productId);

        // Cek Stok
        if ($product->stock <= 0) {
            session()->flash('error', 'Stok barang habis!');
            return;
        }

        // Tentukan Harga Berdasarkan Tipe yang Dipilih
        $price = 0;
        if ($this->selectedPriceTypeId == 1) $price = $product->price_retail;       // Ritel
        elseif ($this->selectedPriceTypeId == 2) $price = $product->price_semi_wholesale; // Semi
        elseif ($this->selectedPriceTypeId == 3) $price = $product->price_wholesale;    // Grosir

        // Masukkan ke Array Cart
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['qty']++; // Jika sudah ada, tambah qty
        } else {
            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'qty' => 1,
                'unit' => $product->unit
            ];
        }
    }

    // 3. Update Qty / Hapus Item
    public function increaseQty($productId)
    {
        $this->cart[$productId]['qty']++;
    }

    public function decreaseQty($productId)
    {
        if ($this->cart[$productId]['qty'] > 1) {
            $this->cart[$productId]['qty']--;
        } else {
            unset($this->cart[$productId]); // Hapus jika 0
        }
    }

    public function removeItem($productId)
    {
        unset($this->cart[$productId]);
    }

    // --- HITUNG-HITUNGAN ---

    public function getTotalProperty()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    public function getChangeProperty()
    {
        return (int)$this->paymentAmount - $this->getTotalProperty();
    }

    // --- CHECKOUT (SIMPAN TRANSAKSI) ---

    public function checkout()
    {
        // 1. Validasi
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong!');
            return;
        }

        if ($this->paymentAmount < $this->getTotalProperty()) {
            session()->flash('error', 'Uang pembayaran kurang!');
            return;
        }

        // 2. Siapkan variabel penampung ID (Awalnya null)
        $newSaleId = null;

        // 3. Database Transaction
        // [PERHATIKAN INI] Wajib ada tanda '&' sebelum $newSaleId
        // Penulisan yang benar: use (&$newSaleId)
        DB::transaction(function () use (&$newSaleId) {

            // A. Simpan Header Nota
            $sale = Sale::create([
                'invoice_number' => 'INV-' . time(),
                'user_id' => Auth::id(),
                'customer_type_id' => $this->selectedPriceTypeId,
                'customer_name' => null, // Biarkan null sesuai alur cepat
                'total_amount' => $this->getTotalProperty(),
                'payment_method' => $this->paymentMethod ?? 'Tunai',
                'paid_amount' => $this->paymentAmount,
                'change_amount' => $this->getChangeProperty(),
                'created_at' => now(),
            ]);

            // [PERHATIKAN INI] Isi variabel penampung dengan ID yang baru dibuat
            $newSaleId = $sale->id;

            // B. Simpan Item & Kurangi Stok
            foreach ($this->cart as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price_at_sale' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Kurangi Stok
                Product::where('id', $item['id'])->decrement('stock', $item['qty']);
            }
        });

        // 4. Pengecekan Terakhir (Debugging)
        if (is_null($newSaleId)) {
            // Jika masuk sini, berarti transaksi gagal atau tanda '&' lupa ditulis
            session()->flash('error', 'Gagal mendapatkan ID Transaksi. Cek kode use (&$newSaleId).');
            return;
        }

        // 5. Reset Halaman
        $this->cart = [];
        $this->paymentAmount = 0;
        $this->selectedPriceTypeId = null;
        $this->paymentMethod = 'Tunai';

        // 6. Redirect (Sekarang ID pasti sudah ada isinya)
        return redirect()->route('sales.print', ['sale' => $newSaleId]);
    }

    public function render()
    {
        // Ambil produk (filter pencarian)
        $products = Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->take(20) // Batasi 20 produk agar ringan
            ->get();

        return view('livewire.pos-page', [
            'products' => $products
        ]);
    }
}
