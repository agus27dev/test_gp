<?php

namespace App\Models\Traits\Transaction;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TransactionRelation
{
    /**
     * Get the category that owns the transaction.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
