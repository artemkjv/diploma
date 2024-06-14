<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'title',
        'content',
        'styles',
        'news_category_id',
        'user_id',
        'page_id',
        'image',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(NewsCategory::class, 'news_category_id', 'id');
    }

    public function page() {
        return $this->belongsTo(Page::class);
    }

    public static function paginate(User $user) {
        return $user->news()
            ->with(['category', 'user'])
            ->orderByDesc('id')
            ->paginate(self::PAGINATE);
    }

    public static function getByUserAndId(User $user, int|string $id) {
        return $user->news()
            ->with(['page', 'category'])
            ->findOrFail($id);
    }


}
