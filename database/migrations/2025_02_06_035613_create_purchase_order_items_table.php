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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Purchase_Orders_ID')
                ->nullable()
                ->constrained(table: 'purchase_orders')
                ->onDelete('set null');
            $table->text('Item_Name');
            $table->text('Item_Description')->nullable();
            $table->bigInteger('Quantity');
            $table->bigInteger('Price');
            $table->text('Unit');
            $table->text('Tax')->nullable();
            $table->bigInteger('Tax_Amount')->nullable();
            $table->bigInteger('Discount')->nullable();
            $table->bigInteger('Total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
