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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id('detail_id');
            $table->integer('kode_penjualan')->nullable;
            $table->integer('produk_id')->nullable;
            $table->integer('jumlah_produk')->nullable;
            $table->decimal('subtotal',10,2)->nullable;
            $table->integer('pelanggan_id')->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
