<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class Expense extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'budget_limit_id', 'name', 'amount', 'start_date'
    ];

    protected static function booted()
    {
        static::creating(function ($expense) {
            $totalExpenses = self::where('budget_limit_id', $expense->budget_limit_id)->sum('amount');
            $budget = $expense->budgetLimit->amount;

            if (($totalExpenses + $expense->amount) > $budget) {
                throw ValidationException::withMessages([
                    'amount' => 'You have exceeded the available budget for this limit.'
                ]);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function budgetLimit(): BelongsTo
    {
        return $this->belongsTo(BudgetLimit::class);
    }
}