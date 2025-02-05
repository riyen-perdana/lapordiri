<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kkot extends Model
{
    protected $table = 'kkot';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kkot_prov_id',
        'kkot_kode',
        'kkot_nama'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function kkotNama(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::strtoupper($value),
        );
    }

    public function prov(): BelongsTo
    {
        return $this->belongsTo(Prov::class, 'kkot_prov_id');
    }
}
