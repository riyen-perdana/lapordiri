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
        Schema::create('bch', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('bch_sesi')->comment('Batch Pendaftaran');
            $table->date('bch_tgl_awl')->comment('Tanggal Awal Pendaftaran');
            $table->date('bch_tgl_akhir')->comment('Tanggal Akhir Pendaftaran');
            $table->integer('bch_sts')->comment('Status Batch Pendaftaran')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bch');
    }
};
