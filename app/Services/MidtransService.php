<?php 

namespace App\Services;

class MidtransService {

    protected $midtransProd, $serverKey;

    public function __construct()
    {
        $this->midtransProd = (env("APP_ENV") == 'production') ? true : false;
        $this->serverKey    = (env("APP_ENV") == 'production') ? "" : "SB-Mid-server-jV2c34fnF4FyjVP-9uvDhK5R";
    }

    public function getSnapToken($invoiceNo, $amount) {
        \Veritrans_Config::$serverKey = $this->serverKey;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Veritrans_Config::$isProduction = $this->midtransProd;

        // Set sanitization on (default)
        \Veritrans_Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Veritrans_Config::$is3ds = true;
    
        $snap_token = \Veritrans_Snap::getSnapToken([
            "transaction_details" => [
                "order_id"      => $invoiceNo,
                "gross_amount"  => (int) $amount + 4400 // amount + fee midtrans
            ],
            [
                "id"            => "Bill-" . $invoiceNo,
                "price"         => (int)$amount,
                "quantity"      => 1,
                "name"          => "Bill Invoice Pembayaran " . $invoiceNo,
                "category"      => "Invoice",
                "merchant_name" => "event.onar.asia"
            ],
            [
                "id"            => "TRX-" . $invoiceNo,
                "price"         => 4400,
                "quantity"      => 1,
                "name"          => "Biaya per Transaksi Pembayaran",
                "category"      => "Invoice",
                "merchant_name" => "Midtrans.com"
            ],
            "enabled_payments"   => ["bca_va", "bni_va", "other_va", "echannel", "gci", "credit_card", "gopay"]
        ]);

        return $snap_token;
    }
}