<?php

namespace App\Models\Traits\Transaction;

use Carbon\Carbon;

trait TransactionMutator
{
    /**
     * Set the description attribute with proper formatting.
     *
     * @param string|null $value
     * @return void
     */
    public function setDescriptionAttribute(?string $value): void
    {
        $this->attributes['description'] = $value ? ucfirst(trim($value)) : null;
    }

    /**
     * Set the transaction_date attribute ensuring proper date format.
     *
     * @param mixed $value
     * @return void
     */
    public function setTransactionDateAttribute($value): void
    {
        $this->attributes['transaction_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
