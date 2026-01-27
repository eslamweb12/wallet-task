<?php

namespace App\Interfaces;

interface WebhookInterface
{
    public function parse( string $payload);

}
