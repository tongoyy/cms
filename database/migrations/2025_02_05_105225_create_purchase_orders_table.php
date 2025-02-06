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
            $table->unsignedBigInteger('Purchase_Requests_ID');
            $table->unsignedBigInteger('Vendors_ID'); // New foreign key column
            $table->bigInteger('Number');
            $table->text('PO_Code');
            $table->text('PO_Name');
            $table->text('Purchase_Request');
            $table->date('Order_Date');
            $table->text('Department');
            $table->text('Category');
            $table->text('Project');
            $table->foreign('Purchase_Requests_ID')->references('id')->on('purchase_requests');
            $table->foreign('vendors_id')->references('id')->on('vendors'); // Foreign key constraint
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
