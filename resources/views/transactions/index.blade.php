@extends('layouts.app')

@section('title', 'Transaksi - Financial Management')

@section('content')
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card summary-card bg-white">
                <div class="card-body">
                    <p class="card-title mb-1">Total Pemasukan</p>
                    <p class="card-value text-success mb-0" id="totalIncome">
                        {{ formatRupiah($totalIncome) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card summary-card bg-white">
                <div class="card-body">
                    <p class="card-title mb-1">Total Pengeluaran</p>
                    <p class="card-value text-danger mb-0" id="totalExpense">
                        {{ formatRupiah($totalExpense) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card summary-card bg-white">
                <div class="card-body">
                    <p class="card-title mb-1">Saldo</p>
                    <p class="card-value {{ $balance >= 0 ? 'text-primary' : 'text-danger' }} mb-0" id="totalBalance">
                        {{ formatRupiah($balance) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Transaksi</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
        </button>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="transactionTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="income-tab" data-bs-toggle="tab" data-bs-target="#income"
                type="button" role="tab" aria-controls="income" aria-selected="true">
                <i class="bi bi-arrow-down-circle text-success me-1"></i> Pemasukan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense"
                type="button" role="tab" aria-controls="expense" aria-selected="false">
                <i class="bi bi-arrow-up-circle text-danger me-1"></i> Pengeluaran
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content bg-white border border-top-0 rounded-bottom p-3" id="transactionTabContent">
        <!-- Income Tab -->
        <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="incomeTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Expense Tab -->
        <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="expenseTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransactionModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTransactionForm">
                    <div class="modal-body">
                        <!-- Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            <div class="invalid-feedback" id="error-type"></div>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required disabled>
                                <option value="">-- Pilih Tipe Terlebih Dahulu --</option>
                            </select>
                            <div class="invalid-feedback" id="error-category_id"></div>
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Contoh: 1.000.000" required>
                            </div>
                            <div class="invalid-feedback" id="error-amount"></div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="2"
                                placeholder="Opsional - Keterangan transaksi"></textarea>
                            <div class="invalid-feedback" id="error-description"></div>
                        </div>

                        <!-- Transaction Date -->
                        <div class="mb-3">
                            <label for="transaction_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                            <div class="invalid-feedback" id="error-transaction_date"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    window.transactionStoreUrl = '{{ route("transactions.store") }}';
    window.transactionDatatableUrl = '{{ route("transactions.datatable") }}';
</script>
<script src="{{ asset('js/transactions/index.js') }}"></script>
@endpush
