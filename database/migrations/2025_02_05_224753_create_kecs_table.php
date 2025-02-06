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
        Schema::create('kec', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kec_kkot_id')->comment('Relasi Kode Kabupaten-Kota');
            $table->integer('kec_kode')->unique()->comment('Kode Kecamatam');
            $table->string('kec_nama')->comment('Nama Kecamatan');
            $table->foreign('kec_kkot_id')->references('id')->on('prov')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kec');
    }
};
