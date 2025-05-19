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
        Schema::create('sp3s', function (Blueprint $table) {
            $table->id();

            // Foreign key ke purchase_requests
            $table->unsignedBigInteger('Purchase_Requests_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_requests')
                ->onDelete('set null');

            // Foreign key ke purchase_requests
            $table->unsignedBigInteger('Purchase_Orders_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_orders')
                ->onDelete('set null');

            // Foreign key ke vendors
            $table->unsignedBigInteger('Vendors_ID')->nullable(); // 1. Definisikan kolom
            $table->foreign('Vendors_ID') // 2. Baru tambahkan foreign key
                ->references('id')
                ->on('vendors')
                ->onDelete('set null');

            $table->longText('SP3_Number');
            $table->text('Number');
            $table->longText('Purchase_Request')->nullable();
            $table->longText('Purchase_Order')->nullable();
            $table->text('Vendors');
            $table->date('Date_Created');
            $table->text('Nama_Supplier');
            $table->text('No_Invoice')->nullable();
            $table->date('Tanggal_Invoice')->nullable();;
            $table->text('No_Kwitansi')->nullable();
            $table->date('Tanggal_Kwitansi')->nullable();;
            $table->text('No_DO')->nullable();
            $table->date('Tanggal_DO')->nullable();;
            $table->text('No_FP')->nullable();
            $table->date('Tanggal_FP')->nullable();;
            $table->text('Jenis_Pembayaran');
            $table->text('Untuk_Pembayaran');
            $table->text('Rekening_Bank')->nullable();
            $table->bigInteger('Nomor_Rekening')->nullable();
            $table->text('Atas_Nama');
            $table->text('Lokasi');
            $table->text('Paid_Status');
            $table->bigInteger('Amount');
            $table->bigInteger('PPN');
            $table->bigInteger('PPH');
            $table->bigInteger('Discount')->nullable();
            $table->bigInteger('Jumlah');
            $table->longText('Terbilang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp3s');
    }
};
