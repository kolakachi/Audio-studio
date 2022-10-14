<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransactionLog extends Model
{
    protected $table = 'payment_transaction_logs';
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'txn_id'
    ];
}
