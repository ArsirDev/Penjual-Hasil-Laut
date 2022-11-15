<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Keranjang;
use Xendit\xendit;

class KeranjangController extends BaseController
{
    public function setKeranjang(Request $request)
    {
        $success = Keranjang::insert([
            'id_product' => $request->id_product,
            'user_id' => $request->user_id,
            'product_name' => $request->product_name,
            'email' => $request->email,
            'address' => $request->address,
            'owner_product' => $request->owner_product,
            'payer_name' => auth()->user()->name,
            'amount' => $request->amount,
            'qty' => $request->qty,
            'image' => $request->image
        ]);

        return $this->sendResponse($success, "Successfully insert into cart");
    }

    public function getKeranjang() {
        $success = Keranjang::all();

        return $this->sendResponse($success, "Successfully show cart");
    }

    public function deleteKeranjangById(Request $request) 
    {
        $success = Keranjang::find($request->id)->delete();

        return $this->sendResponse($success, "Successfully delete item");
    }

    public function deleteKeranjang() {
        $success = Keranjang::truncate();

        return $this->sendResponse($success, "Successfully delete cart");
    }
}
