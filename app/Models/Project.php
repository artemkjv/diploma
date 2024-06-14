<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'name',
        'user_id',
        'project_status_id',
        'description',
        'start_date',
        'end_date'
    ];

    public function status() {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function paginate(User $user) {
        return $user
            ->projects()
            ->with('status', 'user')
            ->orderByDesc('id')
            ->paginate(self::PAGINATE)
            ->withQueryString();
    }

    public static function getByUserAndId(User $user, int|string $id) {
        return $user
            ->projects()
            ->with(['status', 'files'])
            ->findOrFail($id);
    }

    public function files() {
        return $this->morphToMany(File::class, 'fileable');
    }

}
