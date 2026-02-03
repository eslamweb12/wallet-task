<?php

namespace App\Services\Parsers;

use App\Interfaces\WebhookInterface;
use Illuminate\Support\Facades\Log;

class PayTechParser implements WebhookInterface
{
    public function parse(string $payload): array
    {
        // فصل كل سطر، سواء كان \n أو \r\n
        $lines = preg_split("/\r\n|\n|\r/", trim($payload));
        $transactions = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                continue; // تجاهل السطور الفاضية
            }

            $parts = explode('#', $line);

            if (count($parts) < 3) {
                Log::warning('Invalid PayTech line format', ['line' => $line]);
                continue;
            }

            [$dateAmount, $bankReference, $meta] = $parts;

            // استخراج المبلغ بعد أول 8 خانات (YYYYMMDD)
            $rawAmount = substr($dateAmount, 8);      // بعد أول 8 خانات للتاريخ
            $rawAmount = str_replace(',', '.', $rawAmount); // حول ',' إلى '.'
            $amount = floatval($rawAmount);

            // استخراج internal_reference من meta
            preg_match('/internal_reference\/([A-Za-z0-9\-]+)/', $meta, $matches);
            $walletReference = $matches[1] ?? null;

            if (!$walletReference) {
                Log::warning('Missing internal_reference in PayTech meta', ['meta' => $meta]);
                continue;
            }

            $transactions[] = [
                'wallet_reference' => $walletReference, // لو محتاج الربط بالمحفظة بعدين
                'reference'        => trim($bankReference),
                'amount'           => $amount,
                'type'             => 'credit',
                'bank'             => 'paytech',
            ];
        }

        return $transactions;
    }
}
