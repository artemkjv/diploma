<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'name',
        'description',
        'image',
        'content',
        'styles',
        'editor_id',
        'page_id',
    ];

    public static function getByUserAndId(User $user, int|string $id)
    {
        return $user->events()
            ->with('page')
            ->findOrFail($id);
    }

    public function user() {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function page() {
        return $this->belongsTo(Page::class);
    }

    public static function paginate(User $user) {
        return $user->events()
            ->with(['user', 'page'])
            ->orderByDesc('id')
            ->paginate(self::PAGINATE);
    }

}
