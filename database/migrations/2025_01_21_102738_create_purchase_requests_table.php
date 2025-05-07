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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('PR_Code');

            // Foreign key ke purchase_requests
            $table->foreignId('Purchase_Requests_ID') // Gunakan snake_case
                ->nullable()
                ->constrained('purchase_requests')
                ->onDelete('set null');

            // Foreign key ke vendors
            $table->unsignedBigInteger('Vendors_ID')->nullable(); // 1. Definisikan kolom
            $table->foreign('Vendors_ID') // 2. Baru tambahkan foreign key
                ->references('id')
                ->on('vendors')
                ->onDelete('set null');

            $table->bigInteger('Number')->nullable();
            $table->text('PR_Name');
            $table->string('Project');
            $table->string('Department');
            $table->string('Vendors');
            $table->string('CompanyName');
            $table->string('PurchaseType');
            $table->string('Category');
            $table->dateTime('DueDate');
            $table->string('RequestedBy')->nullable();
            $table->text('Description')->nullable();
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
        Schema::dropIfExists('purchase_requests');
    }
};
