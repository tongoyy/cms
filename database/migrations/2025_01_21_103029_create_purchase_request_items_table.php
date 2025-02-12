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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Purchase_Requests_ID')->constrained(table: 'purchase_requests');
            $table->text('Item_Name');
            $table->text('Item_Description');
            $table->bigInteger('Quantity');
            $table->bigInteger('Price');
            $table->string('Unit');
            $table->text('Tax');
            $table->bigInteger('Tax_Amount');
            $table->bigInteger('Total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
