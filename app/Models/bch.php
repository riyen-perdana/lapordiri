<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class bch extends Model
{
    protected $table = 'bch';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'bch_sesi',
        'bch_tgl_awl',
        'bch_tgl_akhir',
        'bch_sts'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
