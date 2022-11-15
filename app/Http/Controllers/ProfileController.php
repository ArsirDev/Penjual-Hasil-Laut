<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController;


class ProfileController extends BaseController
{
    public function profil(Request $request) 
    {
        $id = $request->id;

        $response = User::find($id);

        return $this->sendResponse($response, "Successfully get User");
    }
}
