<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom foreignId 'supplier_id'
            // nullable() mengizinkan kolom ini kosong [cite: 369]
            // constrained() otomatis menghubungkan ke 'id' di tabel 'suppliers' [cite: 370]
            $table->foreignId('supplier_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['supplier_id']);
            // Hapus kolomnya
            $table->dropColumn('supplier_id');
        });
    }
};