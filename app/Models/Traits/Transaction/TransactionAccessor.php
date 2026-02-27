<?php

namespace App\Models\Traits\Transaction;

trait TransactionAccessor
{
    /**
     * Get formatted amount in Rupiah currency.
     *
     * @return string
     */
    public function getFormattedAmountAttribute(): string
    {
        return formatRupiah($this->amount);
    }

    /**
     * Get formatted transaction date.
     *
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return \Carbon\Carbon::parse($this->transaction_date)->format('d F Y');
    }
}
