<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Jnp extends Model
{
    protected $table = 'jnp';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'jnp_nama',
        'jnp_status',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function jnpNama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }
}
