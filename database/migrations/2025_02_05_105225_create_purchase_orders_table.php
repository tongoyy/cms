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
            $table->foreignId('Purchase_Requests_ID')->nullable()->constrained('purchase_requests');
            $table->unsignedBigInteger('Vendors_ID')->nullable()->constrained('vendors');
            $table->text('PO_Code');
            $table->bigInteger('Number');
            $table->text('PO_Name');
            $table->text('Vendors');
            $table->text('Purchase_Request');
            $table->date('Order_Date');
            $table->text('Department');
            $table->text('Category');
            $table->text('Project');
            $table->text('SubTotal');
            $table->text('GrandTotal');
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
