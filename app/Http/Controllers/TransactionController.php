<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Services\CategoryService;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;
    protected CategoryService $categoryService;

    public function __construct(
        TransactionService $transactionService,
        CategoryService $categoryService
    ) {
        $this->transactionService = $transactionService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display listing of transactions.
     *
     * @return View
     */
    public function index(): View
    {
        $totalIncome = 0;
        $totalExpense = 0;
        $balance = 0;

        return $this->responseView('transactions.index', compact(
            'totalIncome',
            'totalExpense',
            'balance'
        ));
    }

    /**
     * Get transactions data for DataTable.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request): JsonResponse
    {
        $type = $request->get('type', 'income');

        return $this->transactionService->handleGetTransactionDatatable($type)->getResult()->make(true);
    }

    /**
     * Store a newly created transaction.
     *
     * @param StoreTransactionRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        return $this->transactionService->handleStoreTransaction($request->validated())->json();
    }

    /**
     * Remove the specified transaction.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->transactionService->handleDeleteTransaction($id)->json();
    }
}
