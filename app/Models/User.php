<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const PAGINATE = 10;

    public function projects() {
        return match ($this->role) {
            Role::ADMIN->value => Project::query(),
            Role::EDITOR->value => $this->hasMany(Project::class),
            default => self::query()
                ->whereNull('id'),
        };
    }

    public function events() {
        return match ($this->role) {
            Role::ADMIN->value => Event::query(),
            Role::EDITOR->value => $this->hasMany(Event::class),
            default => self::query()
                ->whereNull('id'),
        };
    }

    public function news() {
        return match ($this->role) {
            Role::ADMIN->value => News::query(),
            Role::EDITOR->value => $this->hasMany(News::class),
            default => self::query()
                ->whereNull('id'),
        };
    }

    public static function paginate() {
        return User::query()
            ->where('role', '!=', Role::ADMIN)
            ->orderByDesc('id')
            ->paginate(self::PAGINATE);
    }

    public static function getById(int|string $id) {
        return User::query()
            ->where('role', '!=', Role::ADMIN)
            ->where('id', $id)
            ->firstOrFail();
    }

}
