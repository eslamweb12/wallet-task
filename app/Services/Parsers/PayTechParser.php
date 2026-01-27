<?php

namespace App\Services\Parsers;

use App\Interfaces\WebhookInterface;

class PayTechParser implements WebhookInterface
{
    public function parse(string $payload): array
    {
        $lines = explode("\n", trim($payload));
        $transactions = [];

        foreach ($lines as $line) {
            [$dateAmount, $bankReference, $meta] = explode('#', $line);

            $amount = str_replace(',', '.', substr($dateAmount, 8));

            preg_match('/internal_reference\/([A-Za-z0-9\-]+)/', $meta, $matches);
            $walletReference = $matches[1] ?? null;

            if (!$walletReference) {
                continue; // safety
            }

            $transactions[] = [
                'wallet_reference' => $walletReference,
                'reference'        => $bankReference, // 👈 مهم
                'amount'           => (float) $amount,
                'type'             => 'credit',
                'bank'             => 'paytech',
            ];
        }

        return $transactions;
    }
}
