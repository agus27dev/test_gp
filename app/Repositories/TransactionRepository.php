<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    /**
     * Get base query for transactions with category relation.
     *
     * @param string|null $type
     * @return Builder
     */
    public function getTransactionQuery(?string $type = null): Builder
    {
        return Transaction::with('category')
            ->when($type, fn (Builder $query, string $type) => $query->where('type', $type))
            ->orderBy('transaction_date', 'desc');
    }

    /**
     * Get all transactions, optionally filtered by type.
     *
     * @param string|null $type
     * @return Collection
     */
    public function getAllTransactions(?string $type = null): Collection
    {
        return $this->getTransactionQuery($type)->get();
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
     * Get a transaction by ID.
     *
     * @param int $id
     * @return Transaction|null
     */
    public function getTransactionById(int $id): ?Transaction
    {
        return Transaction::with('category')->find($id);
    }

    /**
     * Delete a transaction by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteTransaction(int $id): bool
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return false;
        }

        return $transaction->delete();
    }
}
