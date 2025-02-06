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
        Schema::create('purchase_order_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('Discount');
            $table->bigInteger('Sub_Total');
            $table->bigInteger('Shipping_Fee');
            $table->bigInteger('Shipping_Fee');
            $table->bigInteger('Grand_Total');
            $table->text('Terbilang');
            $table->text('Payment_Terms');
            $table->text('Delivery_Time');
            $table->text('Inspection_Note');
            $table->text('Vendor_Note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_results');
    }
};
