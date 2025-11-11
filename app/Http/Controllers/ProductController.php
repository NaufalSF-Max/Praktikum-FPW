<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Membuat query builder baru untuk model Product
        // Langsung lakukan eager loading relasi 'supplier'
        $query = Product::with('supplier');

        // Cek apakah ada parameter 'search' di request
        if ($request->has('search') && $request->search != '') {
            // Melakukan pencarian berdasarkan nama produk atau informasi
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                  ->orWhere('information', 'like', '%' . $search . '%'); // Bisa ditambahkan kolom lain
            });
        }

        // --- AWAL LOGIKA SORTING (BARU) ---
        
        // Ambil parameter sort dan direction dari request, beri nilai default
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        // Daftar kolom yang boleh di-sort (untuk keamanan)
        $sortableColumns = ['id', 'product_name', 'unit', 'type', 'information', 'qty', 'producer'];

        // Terapkan orderBy jika kolom dan arahnya valid
        if (in_array($sort, $sortableColumns) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }
        
        // --- AKHIR LOGIKA SORTING ---


        // --- MODIFIKASI PAGINASI ---
        // 'appends($request->except('page'))' akan membawa semua parameter 
        // (termasuk search, sort, direction) saat pindah halaman.
        $data = $query->paginate(2)->appends($request->except('page'));

        // Kirim $data, $sort, dan $direction ke view
        return view("master-data.product-master.index-product", compact('data', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all(); // Ambil semua data supplier
        // Kirim data suppliers ke view
        return view("master-data.product-master.create-product", compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input data
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        try {
            // Proses simpan data ke dalam database
            product::create($validasi_data);
    
            // DIUBAH: Redirect ke halaman INDEX (view data) jika berhasil
            return redirect()->route('product-index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            // BARU: Redirect kembali ke form create jika gagal
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.detail-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all(); // Ambil semua data supplier
        // Kirim data product dan suppliers ke view
        return view('master-data.product-master.edit-product', compact('product', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'information' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'producer' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update([
                'product_name' => $request->product_name,
                'unit' => $request->unit,
                'type' => $request->type,
                'information' => $request->information,
                'qty' => $request->qty,
                'producer' => $request->producer,
                'supplier_id' => $request->supplier_id,
            ]);
    
            // DIUBAH: Redirect ke halaman INDEX (view data) jika berhasil
            return redirect()->route('product-index')->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            // BARU: Redirect kembali ke form edit jika gagal
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->back()->with('success', 'Product berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Product tidak ditemukan.');
    }

    public function exportExcel() {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    
    public function exportPDF()
    {
        // 1. Ambil semua data produk dari database
        $products = product::all();

        // 2. Load view Blade yang sudah Anda buat (export-pdf.blade.php)
        //    dan teruskan data $products ke dalamnya
        $pdf = PDF::loadView('master-data.product-master.export-pdf', compact('products'));

        // 3. Download file PDF dengan nama kustom
        return $pdf->download('rekap-mutasi-stock.pdf');
    }

    public function exportHTML()
    {
        // 1. Ambil semua data produk
        $products = product::all();

        // 2. Render view export-pdf.blade.php sebagai string HTML
        $html = view('master-data.product-master.export-pdf', compact('products'))->render();

        // 3. Kembalikan HTML ini dalam format JSON
        return response()->json(['html' => $html]);
    }
}
