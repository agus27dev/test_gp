<?php

namespace App\Models;

use App\Models\Traits\Transaction\TransactionAccessor;
use App\Models\Traits\Transaction\TransactionMutator;
use App\Models\Traits\Transaction\TransactionRelation;
use App\Models\Traits\Transaction\TransactionScope;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use TransactionAccessor;
    use TransactionMutator;
    use TransactionRelation;
    use TransactionScope;

    protected $fillable = [
        'category_id',
        'type',
        'amount',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'amount' => 'integer',
        'transaction_date' => 'date',
    ];
}
