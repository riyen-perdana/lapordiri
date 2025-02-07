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
        Schema::create('unv', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('unv_kode')->comment('Kode Universitas');
            $table->string('unv_nama')->comment('Nama Universitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unv');
    }
};
