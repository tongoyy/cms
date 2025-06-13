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
        Schema::create('laporan_petty_cashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Petty_Cash_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('petty_cashes')
                ->onDelete('set null');
            $table->date('TanggalLaporan')->nullable();
            $table->integer('QuantityNumber')->nullable();
            $table->string('QuantityText')->nullable();
            $table->string('Posting')->nullable();
            $table->string('Keterangan')->nullable();
            $table->string('Kegunaan')->nullable();
            $table->integer('HargaSatuan');
            $table->integer('HargaTotal');
            $table->string('Vendor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_petty_cashes');
    }
};
