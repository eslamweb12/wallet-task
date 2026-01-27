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
        $bankName = $request->header('BankName');
        $payload  = $request->getContent();

        $parser = BankWebhookFactory::make($bankName);
        $transactions = $parser->parse($payload);

        foreach ($transactions as $transaction) {
            try {
                $walletService->handle($transaction);
            } catch (\Throwable $e) {
                Log::error('Wallet webhook error', [
                    'error' => $e->getMessage(),
                    'data'  => $transaction,
                ]);
            }
        }

        return $this->successResponse([
            'processed' => count($transactions),
        ]);
    }

    public function send(XmlRequest $request){
        $data = $request->validated();

        $data['Refrence']='TX-' . Str::uuid();
        $data['date'] = now()->format('Y-m-d H:i:sP');

        $xmlBuild=new XmlBuilderService($data);
        $xml=$xmlBuild->build();

        return response($xml,200)->header('Content-Type', 'application/xml');


    }
}
