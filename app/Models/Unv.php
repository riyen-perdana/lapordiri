<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected function unvNama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::upper($value),
        );
    }

    public function prdp(): HasMany
    {
        return $this->hasMany(Prdp::class);
    }

}
