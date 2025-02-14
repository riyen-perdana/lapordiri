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
        Schema::table('ppg', function (Blueprint $table) {
            $table->string('ppg_set_id')->nullable()->after('ppg_jnp_id');
            $table->string('ppg_batch_id')->nullable()->after('ppg_set_id');
            $table->integer('ppg_sts_vrf')->default(0)->after('ppg_batch_id')->comment('Status Verifikasi');
            $table->foreign('ppg_set_id')->references('id')->on('set');
            $table->foreign('ppg_batch_id')->references('id')->on('bch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppg', function (Blueprint $table) {
            //
        });
    }
};
