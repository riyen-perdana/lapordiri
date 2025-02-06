<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prov extends Model
{
    protected $table = 'prov';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['prov_kode', 'prov_nama'];



    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    /**
     * TODO : Accessor And Mutator Attribute prov_nama
     */
    protected function provNama(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::ucwords($value),
        );
    }


    /**
     * TODO : Relation With kabkot Model
     */
    public function kabkot(): HasMany
    {
        return $this->hasMany(Kkot::class, 'kkot_prov_id');
    }
}
