<?php

namespace App\Models;

use App\Enums\Semester;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $table = 'set';
    public $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['set_thn', 'set_smt', 'set_sts'];

    protected $casts = [
        'set_smt' => Semester::class,
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

}
