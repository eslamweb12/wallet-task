<?php

namespace App\Services\Wallet;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Exception;

class WalletService
{
    public function handle(array $data): void
    {
        DB::transaction(function () use ($data) {

            // 1️⃣ Idempotency
            if (Transaction::where('reference', $data['reference'])->exists()) {
                return;
            }

            // 2️⃣ Lock wallet row
            $wallet = Wallet::where('reference', $data['wallet_reference'])
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                throw new Exception('Wallet not found');
            }

            $amount = (float) $data['amount'];
            $type   = $data['type'] ?? 'credit';

            // 3️⃣ Prevent negative balance
            if ($type === 'debit' && $wallet->balance < $amount) {
                throw new Exception('Insufficient balance');
            }

            // 4️⃣ Create transaction
            $wallet->transactions()->create([
                'reference' => $data['reference'],
                'amount'    => $amount,
                'type'      => $type,
                'bank'      => $data['bank'] ?? null,
            ]);

            // 5️⃣ Update wallet balance
            if ($type === 'credit') {
                $wallet->increment('balance', $amount);
            } else {
                $wallet->decrement('balance', $amount);
            }
        });
    }
}
