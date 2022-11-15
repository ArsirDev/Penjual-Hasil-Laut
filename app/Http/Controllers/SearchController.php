<?php

namespace App\Http\Controllers;

use App\Models\HasilLaut;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class SearchController extends BaseController
{

    public function index()
    {
        $table = HasilLaut::paginate(10);

        return $this->sendResponse($table, "berhasil");
    }

    public function search(Request $request)
    {
        $search = $request->product_name;

        $table = HasilLaut::when($search, function ($q) use ($search) {
            $q->where('product_name', 'like', "%" . $search . "%");
        })->get();

        return $this->sendResponse($table, "Successfully Search Product");
    }
}
