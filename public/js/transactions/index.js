$(document).ready(function () {
    /**
     * Initialize DataTable for a given type.
     *
     * @param {string} tableId
     * @param {string} type
     * @param {string} colorClass
     * @returns {DataTable}
     */
    function initDataTable(tableId, type, colorClass) {
        return $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: window.transactionDatatableUrl,
                data: { type: type },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'formatted_date', name: 'transaction_date' },
                {
                    data: 'category_name',
                    name: 'category.name',
                    render: function (data) {
                        return '<span class="badge bg-' + colorClass + '-subtle text-' + colorClass + '">' + data + '</span>';
                    },
                },
                {
                    data: 'description',
                    name: 'description',
                    render: function (data) {
                        return data ?? '-';
                    },
                },
                {
                    data: 'formatted_amount',
                    name: 'amount',
                    className: 'text-end fw-semibold text-' + colorClass,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                },
            ],
            language: {
                processing: 'Memuat...',
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(disaring dari _MAX_ total data)',
                zeroRecords: 'Tidak ada data yang cocok',
                emptyTable: 'Belum ada data transaksi.',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Selanjutnya',
                    previous: 'Sebelumnya',
                },
            },
        });
    }

    // Initialize DataTables
    let incomeTable = initDataTable('incomeTable', 'income', 'success');
    let expenseTable = null;

    // Lazy-load expense table on tab click
    $('button[data-bs-target="#expense"]').on('shown.bs.tab', function () {
        if (!expenseTable) {
            expenseTable = initDataTable('expenseTable', 'expense', 'danger');
        } else {
            expenseTable.ajax.reload();
        }
    });

    /**
     * Format amount input to Rupiah on keyup.
     */
    $('#amount').on('keyup', function () {
        let value = $(this).val();
        $(this).val(formatRupiah(value));
    });

    /**
     * Load categories based on selected type.
     */
    $('#type').on('change', function () {
        let type = $(this).val();
        let categorySelect = $('#category_id');

        if (!type) {
            categorySelect.html('<option value="">-- Pilih Tipe Terlebih Dahulu --</option>');
            categorySelect.prop('disabled', true);
            return;
        }

        categorySelect.prop('disabled', false);
        categorySelect.html('<option value="">Memuat kategori...</option>');

        $.ajax({
            url: '/categories/' + type,
            type: 'GET',
            success: function (response) {
                let options = '<option value="">-- Pilih Kategori --</option>';
                $.each(response.data, function (index, category) {
                    options += '<option value="' + category.id + '">' + category.name + '</option>';
                });
                categorySelect.html(options);
            },
            error: function () {
                categorySelect.html('<option value="">Gagal memuat kategori</option>');
            }
        });
    });

    /**
     * Set default date to today.
     */
    let today = new Date().toISOString().split('T')[0];
    $('#transaction_date').val(today);

    /**
     * Handle form submission - Store Transaction.
     */
    $('#addTransactionForm').on('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        $('.form-control, .form-select').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        let formData = {
            type: $('#type').val(),
            category_id: $('#category_id').val(),
            amount: $('#amount').val(),
            description: $('#description').val(),
            transaction_date: $('#transaction_date').val(),
        };

        $('#btnSubmit').prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...'
        );

        $.ajax({
            url: window.transactionStoreUrl,
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#addTransactionModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function () {
                        window.location.reload();
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        $('#' + field).addClass('is-invalid');
                        $('#error-' + field).text(messages[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan. Silakan coba lagi.',
                    });
                }
            },
            complete: function () {
                $('#btnSubmit').prop('disabled', false).html(
                    '<i class="bi bi-save me-1"></i> Simpan'
                );
            },
        });
    });

    /**
     * Handle Delete Transaction.
     *
     * BUG: URL is missing the transaction ID concatenation.
     * The request will be sent to '/transactions/' instead of '/transactions/{id}'
     */
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data transaksi akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/transactions/',
                    type: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(function () {
                                window.location.reload();
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus transaksi. Silakan coba lagi.',
                        });
                    },
                });
            }
        });
    });

    /**
     * Reset form when modal is closed.
     */
    $('#addTransactionModal').on('hidden.bs.modal', function () {
        $('#addTransactionForm')[0].reset();
        $('.form-control, .form-select').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#category_id').html('<option value="">-- Pilih Tipe Terlebih Dahulu --</option>');
        $('#category_id').prop('disabled', true);
        $('#transaction_date').val(today);
    });
});
