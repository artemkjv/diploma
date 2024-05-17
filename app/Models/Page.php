<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function getByUuid($uuid) {
        return self::query()
            ->where('uuid', $uuid)
            ->first();
    }

}
