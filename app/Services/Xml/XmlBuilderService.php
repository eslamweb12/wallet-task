<?php

namespace App\Services\Xml;

class XmlBuilderService
{
    public  array $data;
    public function __construct( array $data){
        $this->data = $data;

    }
    public function build(){
        $data=$this->data;
        $xml=new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><PaymentRequestMessage></PaymentRequestMessage>');

        //transfer info
        $transaction=$xml->addChild('TransferInfo');
        $transaction->addAttribute('BankName', $data['BankName']);
        $transaction->addAttribute('Reference', $data['Reference']);
        $transaction->addAttribute('Date', $data['Date']);
        $transaction->addAttribute('Amount', $data['Amount']);
        $transaction->addAttribute('Currency', $data['Currency']);


        //sender info
       $sender = $xml->addChild('SenderInfo');
       $sender->addAttribute('AccountNumber', $data['AccountNumber']);

       //$receiver info
        $receiver = $xml->addChild('ReceiverInfo');
        $receiver->addAttribute('BankCode', $data['BankCode']);
        $receiver->addAttribute('AccountNumber', $data['AccountNumber']);
        $receiver->addAttribute('BeneficiaryName', $data['BeneficiaryName']);

        //notes
        if(!empty($data['notes']) && is_array($data['notes'])){
            $notes=$xml->addChild('Notes');
            foreach($data['notes'] as $note){
                $notes->addAttribute('Note', $note);
            }
        }
        if(!empty($data['PaymentType']) && $data['PaymentType'] !=99){
            $xml->addChild('PaymentType', $data['PaymentType']);
        }

        if (!empty($data['charge_details']) && $data['charge_details'] != 'SHA') {
            $xml->addChild('ChargeDetails', $data['charge_details']);
        }

        return $xml->asXML();














    }

}
