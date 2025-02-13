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
        Schema::create('ppg', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ppg_nik')->comment('Nomor Induk Kependudukan');
            $table->string('ppg_simpatika')->comment('Nomor SIMPATIKA');
            $table->string('ppg_nisn')->comment('Nomor Induk Siswa Nasional');
            $table->string('ppg_nama')->comment('Nama Pendaftar');
            $table->string('ppg_email')->unique()->comment('Email Pendaftar');
            $table->string('ppg_nim')->comment('Nomor Induk Mahasiswa')->nullable();
            $table->string('ppg_jnp_id')->comment('UUID Jenis Pendaftaran Relasi Tabel Jnp');
            $table->enum('ppg_kps',['Y','N'])->comment('Penerima KPS')->default('N');
            $table->enum('ppg_jk',['L','P'])->comment('Jenis Kelamin')->default('L');
            $table->string('ppg_agm_id')->comment('UUID Agama Relasi Tabel Agm');
            $table->string('ppg_tpt_lhr')->comment('Tempat Lahir');
            $table->date('ppg_tgl_lhr')->comment('Tanggal Lahir');
            $table->string('ppg_ibu')->comment('Nama Ibu Kandung');
            $table->string('ppg_kec_id')->comment('UUID Kecamatan Relasi Kode Kecamatan');
            $table->string('ppg_kel')->comment('Nama Kelurahan');
            $table->string('ppg_no_hp')->comment('Nomor Handphone Pendaftar');
            $table->string('ppg_no_wa')->comment('Nomor Whatsapp Pendaftar');
            $table->string('ppg_wrgn_id')->comment('UUID Kewarganegaraan');
            $table->string('ppg_sklh')->comment('Sekolah Tempat Mengajar');
            $table->string('ppg_no_ops')->comment('Nomor Operator Sekolah');
            $table->string('ppg_prpd_id')->comment('UUID Program Studi Relasi Kode Program Studi');
            $table->string('ppg_ipk')->comment('IPK Strata 1');
            $table->string('ppg_uktp')->comment('File KTP');
            $table->string('ppg_foto')->comment('File Foto');
            $table->string('ppg_ijz')->comment('File Ijazah');
            $table->string('ppg_trsk')->comment('File Transkrip Nilai');
            $table->string('ppg_sk_ajr')->comment('File SK Ajar');
            $table->string('ppg_prkt_ajr')->comment('File Perangkat Ajar');
            $table->string('ppg_strf')->comment('File Sertifikat Ajar');
            $table->string('ppg_dkmn')->comment('File Dokumen Ajar');
            $table->string('ppg_invs')->comment('File Inovasi');
            $table->timestamps();
            $table->foreign('ppg_jnp_id')->references('id')->on('jnp');
            $table->foreign('ppg_agm_id')->references('id')->on('agm');
            $table->foreign('ppg_kec_id')->references('id')->on('kec');
            // $table->foreign('ppg_wrgn_id')->references('id')->on('wrgn');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppg');
    }
};
