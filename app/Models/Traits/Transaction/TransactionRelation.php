<?php

namespace App\Models\Traits\Transaction;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TransactionRelation
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
