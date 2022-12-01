<?php

namespace App\Http\Controllers;

use App\Models\HasilLaut;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;


class HasilLautController extends BaseController
{
    public function insert(Request $request)
    {
        $path = $request->file('image')->store('images'); 
        $success = HasilLaut::create([
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'address' => auth()->user()->address,
            'number_phone' => auth()->user()->number_phone,
            'status' => auth()->user()->status,
            'product_name' => $request->product_name,
            'qty' => $request->qty,
            'price' => $request->price,
            'type' => $request->type,
            'image' => asset($path),
            'description' => $request->description,
        ]);
        return $this->sendResponse($success, 'Saved Data successfully.');
    }

    public function detail(Request $request)
    {
        // id Kosong
        $kosong = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if($kosong->fails()) { 
            return $this->sendError(
                'Id tidak boleh kosong',
                ['error'=>'Id tidak boleh kosong']
            );
        }

        $id = $request->id;
        $table = HasilLaut::find($id);
        return $this->sendResponse($table, "Get Detail Successfully");
    }
}
