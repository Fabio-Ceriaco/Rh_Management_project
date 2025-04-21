<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    public function users(): BelongsToMany
    {
        // each departments can belongs to many users
        return $this->belongsToMany(User::class);
    }
}
