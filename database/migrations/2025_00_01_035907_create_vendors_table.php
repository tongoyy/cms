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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Number');
            $table->text('VendorCode');
            $table->text('CompanyName');
            $table->text('NPWP')->nullable();
            $table->text('Phone');
            $table->text('Email')->nullable();
            $table->text('Address');
            $table->text('RekeningBank')->nullable();
            $table->text('NomorRekening')->nullable();
            $table->text('AtasNama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
