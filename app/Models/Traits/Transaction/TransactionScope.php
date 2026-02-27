<?php

namespace App\Models\Traits\Transaction;

use Illuminate\Database\Eloquent\Builder;

trait TransactionScope
{
    /**
     * Scope a query to only include expense transactions.
     */
    public function scopeExpense(Builder $query): Builder
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope a query to only include income transactions.
     */
    public function scopeIncome(Builder $query): Builder
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
}
