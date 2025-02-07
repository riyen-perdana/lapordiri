<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Unv extends Model
{
    protected $table = 'unv';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'unv_kode',
        'unv_nama',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function unvNama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::upper($value),
        );
    }

}
