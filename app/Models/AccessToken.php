<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    //
    protected $fillable = [
        'service_id',
        'access_token',
        'refresh_token',
        'expires_at',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
