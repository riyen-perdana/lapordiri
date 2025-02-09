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
        Schema::create('kkot', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kkot_prov_id')->comment('Relasi Kode Provinsi');
            $table->integer('kkot_kode')->unique()->comment('Kode Kabupaten Kota');
            $table->string('kkot_nama')->comment('Nama Kabupaten Kota');
            $table->timestamps();
            $table->foreign('kkot_prov_id')->references('id')->on('prov');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkot');
    }
};
