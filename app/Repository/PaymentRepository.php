<?php

namespace App\Repository;

use App\Models\PaymentLog;
use App\Models\Registration;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;

class PaymentRepository {
    public function requestSnapToken($params) {
        $validator = \Validator::make($params , [
            "invoice"   => "required"
        ]);
        if($validator->fails()) {
            return responseCustom(collect($validator->messages()->first())->implode(","));
        }

        $findInvoice = Registration::where("invoice" , $params["invoice"])
            ->first();

        if(!$findInvoice) {
            return responseCustom("Invoice Not found, please register again");
        }

        $invoicePayment = 'ONR-' . $findInvoice->id . '-' . date("Ymdhis");
        $paymentLog = new PaymentLog();
        $paymentLog->registration_id = $findInvoice->id;
        $paymentLog->payment_id = $invoicePayment;
        $paymentLog->total_amount = $findInvoice->total_price;
        $paymentLog->save();

        return responseCustom((new MidtransService())->getSnapToken($paymentLog->payment_id, $paymentLog->total_amount), true);
    }
}