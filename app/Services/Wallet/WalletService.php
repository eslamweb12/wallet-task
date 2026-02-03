<?php

namespace App\Services\Wallet;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Exception;

class WalletService
{
    public function handle(array $transaction)
    {
        // يمنع التكرار على أساس reference
        $exists = Transaction::where('reference', $transaction['reference'])->exists();

        if ($exists) {
            // تجاهل المعاملة المكررة
            return;
        }

        Transaction::create([
            'reference' => $transaction['reference'],
            'amount'    => $transaction['amount'],
            'type'      => $transaction['type'],
            'bank'      => $transaction['bank'],
        ]);
    }
}
