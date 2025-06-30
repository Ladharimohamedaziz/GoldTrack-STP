<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['user_id', 'name', 'icon', 'type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }
}
