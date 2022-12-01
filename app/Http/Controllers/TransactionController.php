<?php

namespace App\Http\Controllers;

use Xendit\xendit;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    private $token = 'xnd_development_6ntTcAAXexx603gcv8P4dpUYINsCtNWSzW3bIw2c8scY1oPrt6bRfDI3oHc';

    public function transaksi(Request $request)
    {
        Xendit::setApiKey($this->token);
        $external_id = 'va-' . time();

        Transaksi::insert([
            'id_product' => $request->id_product,
            'user_id' => $request->user_id,
            'external_id' => $external_id,
            'product_name' => $request->product_name,
            'email' => $request->email,
            'address' => $request->address,
            'owner_product' => $request->owner_product,
            'payer_name' => auth()->user()->name,
            'amount' => $request->amount,
            'qty' => $request->qty,
            'total_item' => $request->total_item,
            'image' => $request->image,
            'description' => $request->description
        ]);

        $params = [
            'external_id' => $external_id,
            'payer_name' => auth()->user()->name,
            'amount' => $request->amount,
            'description' => $request->description
        ];

        $createInvoice = \Xendit\Invoice::create($params);

        return $this->sendResponse($createInvoice, "Successfully create Invoice");
    }

    public function getTransaksi(Request $request)
    {
        $id = auth()->user()->id;
        $success = Transaksi::where('user_id', 'like', "%" . $id . "%")->get();

        return $this->sendResponse($success, "Successfully show transaksi");

    }
}
