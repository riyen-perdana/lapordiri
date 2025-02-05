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
        Schema::create('prov', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('prov_kode')->unique()->comment('Kode Provinsi');
            $table->string('prov_nama')->comment('Nama Provinsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prov');
    }
};
