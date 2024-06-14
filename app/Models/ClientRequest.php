<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'email',
        'theme',
        'content',
        'client_request_status_id'
    ];

    public static function paginate() {
        return self::query()
            ->with('status')
            ->orderByDesc('id')
            ->paginate(self::PAGINATE);
    }

    public function status() {
        return $this->belongsTo(ClientRequestStatus::class, 'client_request_status_id', 'id');
    }

}
