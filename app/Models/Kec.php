<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kec extends Model
{
    protected $table = 'kec';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kec_prov_id',
        'kec_kode',
        'kec_nama'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function kkot(): BelongsTo
    {
        return $this->belongsTo(Kkot::class, 'kec_kkot_id');
    }
}
