<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::all();
    }

    public function exportExcel() {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
