<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Battle extends Model
{
    /**
     * @return BelongsToMany
     */
    public function participants()
    {
        return $this->belongsToMany(Character::class);
    }

    /**
     * @return HasMany
     */
    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
