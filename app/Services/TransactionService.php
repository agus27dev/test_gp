<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionService extends BaseService
{
    protected TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle get transaction datatable.
     *
     * @param Request $request
     * @return $this
     */
    public function handleGetTransactionDatatable(Request $request): self
    {
        try {
            $query = $this->transactionRepository->builderTransactionForDatatable([
                'type' => $request->type
            ]);

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
     * Handle store transaction.
     *
     * @param Request $request
     * @return $this
     */
    public function handleStoreTransaction(Request $request): self
    {
        try {
            $this->transactionRepository->storeTransaction([
                'category_id' => $request->category_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'transaction_date' => $request->transaction_date,
            ]);

            return $this->setSuccess(true)
                        ->setMessage('Transaksi berhasil disimpan!')
                        ->setCode(201);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }


    /**
     * Handle delete transaction.
     *
     * @param int $id
     * @return $this
     */
    public function handleDeleteTransaction(int $id): self
    {
        try {
            $transaction = $this->transactionRepository->findTransactionById($id);

            $this->transactionRepository->deleteTransaction($transaction);

            return $this->setSuccess(true)
                        ->setMessage('Transaksi berhasil dihapus!')
                        ->setCode(200);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
