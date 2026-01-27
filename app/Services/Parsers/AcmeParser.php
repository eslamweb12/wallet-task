<?php

namespace App\Services\Parsers;

use App\Interfaces\WebhookInterface;

class AcmeParser implements WebhookInterface
{
    public function parse(string $payload): array
    {
        $lines = explode("\n", trim($payload));
        $transactions = [];

        foreach ($lines as $line) {
            [$amount, $bankReference, $date, $walletReference] = explode('//', $line);

            $transactions[] = [
                'wallet_reference' => $walletReference,
                'reference'        => $bankReference, // 👈 مهم
                'amount'           => (float) str_replace(',', '.', $amount),
                'type'             => 'credit',
                'bank'             => 'acme',
            ];
        }

        return $transactions;
    }
}
