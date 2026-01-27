<?php

namespace App\Factories;

use App\Interfaces\WebhookInterface;
use App\Services\Parsers\AcmeParser;
use App\Services\Parsers\PayTechParser;
use Exception;

class BankWebhookFactory
{
    public static function make(string $bank): WebhookInterface
    {
        return match (strtolower($bank)) {
            'acme'    => new AcmeParser(),
            'paytech' => new PayTechParser(),
            default   => throw new Exception('Bank not supported'),
        };
    }
}
