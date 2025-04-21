<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Authenticable // with Fortify to can make login need change the extends from Model to Authenticable
{
    use Notifiable;
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
