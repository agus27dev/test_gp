<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository
{
    /**
     * Get transactions for datatable with optional type filter.
     *
     * @param array $filter
     * @return Builder
     */
    public function builderTransactionForDatatable(array $filter): Builder
    {
        return Transaction::with('category')
            ->when($filter['type'], fn (Builder $query, string $type) => 
                $query->where('type', $type))
            ->orderBy('transaction_date', 'desc');
    }

    /**
     * Store a new transaction.
     *
     * @param array $data
     * @return Transaction
     */
    public function storeTransaction(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Get transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function getTransactionById(int $id): ?Transaction
    {
        return Transaction::with('category')
            ->findOrFail($id);
    }

    /**
     * Delete transaction.
     *
     * @param Transaction $transaction
     * @return bool|null
     */
    public function deleteTransaction(Transaction $transaction)
    {
        return $transaction->delete();
    }
}
