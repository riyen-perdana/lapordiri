<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prdp extends Model
{
    protected $table = 'prdp';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'prdp_unv_id',
        'prdp_kode',
        'prdp_nama',
    ];

    /**
     * TODO : Accessor And Mutator Attribute unv_nama
     */
    protected function prdpNama(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
            get: fn ($value) => Str::ucwords($value),
        );
    }

    /**
     * TODO : Relation With Unv Model
     */
    public function unv(): BelongsTo
    {
        return $this->belongsTo(Unv::class, 'prdp_unv_id');
    }


}
