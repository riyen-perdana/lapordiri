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
        Schema::create('jnp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jnp_nama')->comment('Jenis Pendaftaran');
            $table->integer('jnp_status')->comment('Status Jenis Pendaftaran')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jnp');
    }
};
