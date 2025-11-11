<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'supplier_name',
        'supplier_address',
        'phone',
        'comment'
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Product.
     * Satu supplier bisa memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}