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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            // Foreign key ke vendors
            $table->unsignedBigInteger('Vendors_ID')->nullable(); // 1. Definisikan kolom
            $table->foreign('Vendors_ID') // 2. Baru tambahkan foreign key
                ->references('id')
                ->on('vendors')
                ->onDelete('set null');

            // Foreign key ke purchase_requests
            $table->foreignId('Purchase_Requests_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_requests')
                ->onDelete('set null');

            $table->longText('PO_Code');
            $table->bigInteger('Number')->nullable();
            $table->longText('PO_Name');
            $table->text('Vendors');
            $table->text('Purchase_Request');
            $table->date('Order_Date');
            $table->text('Department');
            $table->text('Category');
            $table->text('Project');
            $table->text('Payment_Mode');
            $table->bigInteger('Sub_Total');
            $table->bigInteger('Discounts')->nullable();
            $table->enum('Discount_Type', ['amount', 'percent']);
            $table->bigInteger('Total_Discount');
            $table->bigInteger('Shipping_Fee')->nullable();
            $table->bigInteger('Grand_Total');
            $table->text('Terbilang');
            $table->text('Delivery_Time');
            $table->text('Payment_Terms');
            $table->text('Inspection_Notes');
            $table->text('Vendor_Notes');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
