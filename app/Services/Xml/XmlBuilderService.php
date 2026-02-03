<?php

namespace App\Services\Xml;

class XmlBuilderService
{
    public function build(array $data): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><PaymentRequestMessage></PaymentRequestMessage>');

        $transferInfo = $xml->addChild('TransferInfo');
        $transferInfo->addChild('Reference', $data['reference']); // ✅
        $transferInfo->addChild('Date', $data['date']);           // ✅
        $transferInfo->addChild('Amount', $data['amount']);
        $transferInfo->addChild('Currency', $data['currency']);

        $senderInfo = $xml->addChild('SenderInfo');
        $senderInfo->addChild('AccountNumber', $data['sender_account']);

        $receiverInfo = $xml->addChild('ReceiverInfo');
        $receiverInfo->addChild('BankCode', $data['receiver_bank_code']);
        $receiverInfo->addChild('AccountNumber', $data['receiver_account']);
        $receiverInfo->addChild('BeneficiaryName', $data['receiver_name']);

        if (!empty($data['notes'])) {
            $notes = $xml->addChild('Notes');
            foreach ($data['notes'] as $note) {
                $notes->addChild('Note', $note);
            }
        }

        if (!empty($data['payment_type'])) {
            $xml->addChild('PaymentType', $data['payment_type']);
        }

        if (!empty($data['charge_details'])) {
            $xml->addChild('ChargeDetails', $data['charge_details']);
        }

        return $xml->asXML();
    }
}
