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
        Schema::create('purchase_request_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Purchase_Request_Items_ID')->constrained('purchase_request_items', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('Subtotal');
            $table->bigInteger('GrandTotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_results');
    }
};
