<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'unit',
        'type',
        'information',
        'qty',
        'producer',
        'supplier_id' // Tambahkan ini [cite: 622]
    ];

    /**
     * Mendefinisikan relasi many-to-one ke model Supplier.
     * Satu produk dimiliki oleh satu supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}