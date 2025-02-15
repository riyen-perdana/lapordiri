<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Jlp extends Model
{
    protected $table = 'jlp';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'jlp_nama',
        'jlp_status',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function jlpNama(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }
}
