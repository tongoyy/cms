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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->id();

            // Foreign key ke Petty Cash
            $table->foreignId('Petty_Cash_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('petty_cashes')
                ->onDelete('set null');

            $table->date('TanggalSaldo')->nullable();
            $table->integer('SaldoAwal')->nullable();
            $table->integer('SaldoMasuk')->nullable();
            $table->integer('SaldoKeluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cashes');
    }
};
