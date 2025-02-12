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
        Schema::create('s_p__tigas', function (Blueprint $table) {
            $table->id();

            // Foreign key ke purchase_requests
            $table->foreignId('Purchase_Requests_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_requests')
                ->onDelete('set null');

            // Foreign key ke purchase_requests
            $table->foreignId('Purchase_Orders_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_orders')
                ->onDelete('set null');

            // Foreign key ke vendors
            $table->unsignedBigInteger('Vendors_ID')->nullable(); // 1. Definisikan kolom
            $table->foreign('Vendors_ID') // 2. Baru tambahkan foreign key
                ->references('id')
                ->on('vendors')
                ->onDelete('set null');

            $table->text('SP3_Number');
            $table->text('Purchase_Request');
            $table->text('Purchase_Order');
            $table->text('Vendors');
            $table->date('Date_Created');
            $table->date('Nama_Supplier');
            $table->date('No_Invoice');
            $table->date('Tanggal_Invoice');
            $table->date('No_Kwitansi');
            $table->date('Tanggal_Kwitansi');
            $table->date('No_DO');
            $table->date('Tanggal_DO');
            $table->date('No_FP');
            $table->date('Tanggal_FP');
            $table->date('Jenis_Pembayaran');
            $table->date('Untuk_Pembayaran');
            $table->date('Rekening_Bank');
            $table->date('Nomor_Rekening');
            $table->date('Atas_Nama');
            $table->date('Lokasi');
            $table->date('Paid_Status');
            $table->date('Amount');
            $table->date('PPN');
            $table->date('PPH');
            $table->date('Discount');
            $table->date('Jumlah');
            $table->date('Terbilang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_p__tigas');
    }
};
