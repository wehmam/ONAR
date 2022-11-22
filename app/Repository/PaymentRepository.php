<?php

namespace App\Repository;

use App\Models\PaymentLog;
use App\Models\Registration;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function paymentCallback($request) {
        try {
            $orderId = $request->get("order_id");

            $paymentLog = PaymentLog::where("payment_id" , $orderId)
                ->first();

            DB::beginTransaction();

            if(!$paymentLog) {
                Log::error("Payment not found", ["data" => json_encode($request->all())]);
                DB::rollback();

                return responseCustom("payment not found", false);
            }   

            if(!is_null($paymentLog->paid_at) && !is_null($paymentLog->registration->paid_at)) {
                Log::error("invoice already paid", ["data" => json_encode($request->all())]);
                DB::rollback();

                return responseCustom("invoice already paid", true);
            }

            $checkNotification = (new MidtransService())->notification($request);
            if(!$checkNotification["status"]) {
                Log::error($checkNotification["message"], ["data"   => json_encode($checkNotification)]);
                return responseCustom($checkNotification, false);
            }

            if($checkNotification['status_server'] == 'success') {
                $paymentLog->status     = "PAID";
                $paymentLog->paid_at    = now();
                $paymentLog->save();

                $paymentLog->registration->update([
                    "status_paid"   => "PAID",
                    "paid_at"       => now()
                ]);
            }

            DB::commit();

            Log::error("Success update information", json_encode(["data" => json_encode($request->all())]));
            return responseCustom("already Paid", true);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ["data"    => json_encode($request->all())]);
            return responseCustom($e->getMessage(), false);
        }
    }
}