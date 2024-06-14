<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'name',
        'contact_info',
        'terms_of_cooperation'
    ];

    public static function paginate() {
        return self::query()
            ->orderByDesc('id')
            ->paginate(self::PAGINATE);
    }



}
