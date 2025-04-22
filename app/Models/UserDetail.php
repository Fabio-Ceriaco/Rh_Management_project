<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    protected $fillable = [
        'address',
        'zip_code',
        'city',
        'phone',
        'salary',
        'admission_date',
    ];
    public function user(): BelongsTo
    {
        // each user as one user_details / each user_details belogs to a single user
        return $this->belongsTo(User::class);
    }
}
