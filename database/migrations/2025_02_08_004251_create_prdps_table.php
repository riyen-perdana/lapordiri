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
        Schema::create('prdp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('prdp_unv_id')->comment('UUID Universitas Relasi Tabel Unv');
            $table->string('prdp_kode')->comment('Kode Program Studi Universitas');
            $table->string('prdp_nama')->comment('Nama Program Studi Universitas');
            $table->timestamps();
            $table->foreign('prdp_unv_id')->references('id')->on('unv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prdp');
    }
};
