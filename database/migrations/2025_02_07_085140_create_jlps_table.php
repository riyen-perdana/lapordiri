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
        Schema::create('jlp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jlp_nama')->comment('Jenis Jalur Penerimaan');
            $table->integer('jlp_status')->comment('Status Jenis Jalur Penerimaan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jlp');
    }
};
