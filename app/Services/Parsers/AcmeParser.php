<?php

namespace App\Services\Parsers;

use App\Interfaces\WebhookInterface;
use Exception;

class AcmeParser implements WebhookInterface
{
    public function parse(string $payload): array
    {
        $lines = explode("\n", trim($payload));
        $transactions = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = explode('//', $line);

            if (count($parts) !== 3) {
                throw new Exception("Invalid Acme transaction format: {$line}");
            }

            [$amount, $bankReference, $walletReference] = $parts;

            $transactions[] = [

                'reference'        => trim($bankReference),
                'amount'           => (float) str_replace(',', '.', $amount),
                'type'             => 'credit',
                'bank'             => 'acme',
            ];
        }


        return $transactions;
    }
}
