<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->amount) {
            // Remove dots (thousand separator) from amount before validation
            $cleanedAmount = preg_replace('/\./', '', $this->amount, 1);

            $this->merge([
                'amount' => (int) $cleanedAmount,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'type.required' => 'Tipe transaksi wajib dipilih.',
            'type.in' => 'Tipe transaksi tidak valid.',
            'amount.required' => 'Jumlah wajib diisi.',
            'amount.integer' => 'Jumlah harus berupa angka.',
            'amount.min' => 'Jumlah minimal 1.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
            'transaction_date.date' => 'Format tanggal tidak valid.',
        ];
    }
}
