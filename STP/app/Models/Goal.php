<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
       protected $fillable = ['user_id', 'name', 'note', 'amount'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
