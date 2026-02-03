<?php

namespace App\Http\Controllers\Payment;

use App\Factories\BankWebhookFactory;
use App\Http\Controllers\BaseController;
use App\Http\Requests\XmlRequest;
use App\Services\Wallet\WalletService;
use App\Services\Xml\XmlBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WebhookController extends BaseController
{
    public function receive(Request $request, WalletService $walletService)
    {
        $bankName = strtolower($request->header('BankName'));

        $payload = match ($bankName) {
            'acme'    => $request->input('payload'),   // JSON
            'paytech' => $request->input('payload'),       // RAW / XML / TEXT
            default   => throw new \Exception('Unsupported bank'),
        };

        if (!$payload) {
            return response()->json([
                'message' => 'Missing payload'
            ], 422);
        }

        $parser = BankWebhookFactory::make($bankName);
        $transactions = $parser->parse($payload);


        foreach ($transactions as $transaction) {
            try {
                $walletService->handle($transaction);
            } catch (\Throwable $e) {
                Log::error('Wallet webhook error', [
                    'bank'  => $bankName,
                    'error' => $e->getMessage(),
                    'data'  => $transaction,
                ]);
            }
        }

        return $this->successResponse([
            'processed' => count($transactions),
        ]);
    }

    public function send(XmlRequest $request)
    {
        $data = $request->validated();

        $data['reference'] = 'TX-' . Str::uuid();  // ✅ صح
        $data['date'] = now()->format('Y-m-d H:i:sP');

        $xmlBuild = new XmlBuilderService();
        $xml = $xmlBuild->build($data);

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

}
