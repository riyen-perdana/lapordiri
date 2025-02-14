<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Ppg extends Model
{
    protected $table = 'ppg';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'ppg_nik',
        'ppg_simpatika',
        'ppg_nisn',
        'ppg_nama',
        'ppg_email',
        'ppg_nim',
        'ppg_kps',
        'ppg_jk',
        'ppg_agm_id',
        'ppg_tpt_lhr',
        'ppg_tgl_lhr',
        'ppg_ibu',
        'ppg_kec_id',
        'ppg_kel',
        'ppg_no_hp',
        'ppg_no_wa',
        'ppg_wrgn_id',
        'ppg_sklh',
        'ppg_no_ops',
        'ppg_prdp_id',
        'ppg_ipk',
        'ppg_uktp',
        'ppg_foto',
        'ppg_ijz',
        'ppg_trsk',
        'ppg_sk_ajr',
        'ppg_prkt_ajr',
        'ppg_strf',
        'ppg_dkmn',
        'ppg_invs',
        'ppg_jlp_id',
        'ppg_jnp_id',
        'ppg_set_id',
        'ppg_batch_id',
        'ppg_sts_vrf'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function ppgNama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }

    protected function ppgTptLhr(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }

    protected function ppgIbu(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }

    protected function ppgSekolah(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::upper($value),
        );
    }

    
}
