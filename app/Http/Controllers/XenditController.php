<?php

namespace App\Http\Controllers;

use Xendit\xendit;
use Carbon\Carbon;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class XenditController extends BaseController
{
    private $token = 'xnd_development_6ntTcAAXexx603gcv8P4dpUYINsCtNWSzW3bIw2c8scY1oPrt6bRfDI3oHc';

    public function getListVa()
    {
        Xendit::setApiKey($this->token);
        $getVABanks = \Xendit\VirtualAccounts::getVABanks();

        return response()->json([
            'data' => $getVABanks
        ])->setStatusCode(200);
    }

    public function createVa(Request $request)
    {
        Xendit::setApiKey($this->token);
        $external_id = 'va-' . time();

        // $params = [
        //     "external_id" => \uniqid(),
        //     "bank_code" => $request->bank,
        //     "name" => $request->user_name,
        //     "expected_amount" => $request->price,
        //     "is_closed" => true,
        //     "expiration_date" => Carbon::now()->addDays(1)->toISOString(),
        //     "is_single_use" => true
        // ];

        $params = [
            "external_id" => $external_id,
            "bank_code" => $request->bank,
            "name" => $request->user_name,
            "expected_amount" => $request->price,
            "is_closed" => true,
            "expiration_date" => Carbon::now()->addDays(1)->toISOString(),
            "is_single_use" => true
        ];

        $insert = Pembayaran::insert([
            "external_id" => $external_id,
            "name" => $request->user_name,
            "email" => $request->email,
            "price" => $request->price,
            "status" => 1,
            "payment_channel" => 'Virtual Account',
        ]);

        $createVA = \Xendit\VirtualAccounts::create($params);
        return response()->json([
            "data" => [
                $createVA,
                $insert
            ]
        ])->setStatusCode(200);
    }

    public function paymentVa(Request $request)
    {
        $paymentID = $request->external_id;
        $getFVAPayment = \Xendit\VirtualAccounts::getFVAPayment($paymentID);
        var_dump($getFVAPayment);
    }

    public function callbackVa(Request $request)
    {
        $external_id = $request->external_id;
        $status = $request->status;
        $payment = Pembayaran::where('external_id', $external_id)->exists();
        if ($payment) {
            if ($status == "PENDING") {
                $update = Pembayaran::where('external_id', $external_id)->update([
                    'status' => 1
                ]);

                if ($update > 0) {
                    return 'ok';
                }

                return 'false';
            }
        } else {
            return $this->sendResponse(
                null,
                'data tidak ada'
            );
        }
    }
}
