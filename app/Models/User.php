<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public function detail(): HasOne
    {
        // each user as one user_details
        return $this->hasOne(UserDetail::class);
    }

    public function department(): BelongsTo
    {
        // this user belongs to a department
        return $this->belongsTo(Department::class);
    }
}
