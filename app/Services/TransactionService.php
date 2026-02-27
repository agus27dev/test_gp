<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Yajra\DataTables\Facades\DataTables;

class TransactionService extends BaseService
{
    protected TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle get all transactions.
     *
     * @param string|null $type
     * @return $this
     */
    public function handleGetAllTransactions(?string $type = null): self
    {
        try {
            $transactions = $this->transactionRepository->getAllTransactions($type);

            return $this->setSuccess(true)
                        ->setResult($transactions)
                        ->setMessage('List data transaksi')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Handle get transactions for DataTable.
     *
     * @param string $type
     * @return $this
     */
    public function handleGetTransactionDatatable(string $type): self
    {
        try {
            $query = $this->transactionRepository->getTransactionQuery($type);

            $dataTable = DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('formatted_date', fn ($row) => $row->formatted_date)
                ->addColumn('category_name', fn ($row) => $row->category->name ?? '-')
                ->addColumn('formatted_amount', fn ($row) => formatRupiah($row->amount))
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $row->id . '">
                                <i class="bi bi-trash"></i>
                            </button>';
                })
                ->rawColumns(['action']);

            return $this->setSuccess(true)
                        ->setResult($dataTable)
                        ->setMessage('DataTable transaksi')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Handle store a new transaction.
     *
     * @param array $data
     * @return $this
     */
    public function handleStoreTransaction(array $data): self
    {
        try {
            $transaction = $this->transactionRepository->storeTransaction($data);

            return $this->setSuccess(true)
                        ->setResult($transaction->load('category'))
                        ->setMessage('Transaksi berhasil disimpan!')
                        ->setCode(201);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Handle delete a transaction.
     *
     * @param int $id
     * @return $this
     */
    public function handleDeleteTransaction(int $id): self
    {
        try {
            $deleted = $this->transactionRepository->deleteTransaction($id);

            if (!$deleted) {
                return $this->setSuccess(false)
                            ->setMessage('Transaksi tidak ditemukan.')
                            ->setCode(404);
            }

            return $this->setSuccess(true)
                        ->setMessage('Transaksi berhasil dihapus!')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
