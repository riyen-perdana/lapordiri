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
        Schema::create('set', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('set_thn')->comment('Tahun Pendaftaran');
            $table->enum('set_smt',['1','2'])->comment('Semester Pendaftaran');
            $table->integer('set_sts')->comment('Status Pendaftaran')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set');
    }
};
