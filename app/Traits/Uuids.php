<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait Uuids
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) $model->id = (string) Uuid::uuid4()->toString();
        });
    }
}
