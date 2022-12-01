<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LoginController extends BaseController
{
    public function login(Request $request)
    { 
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){  
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            $success['address'] = $user->address;
            $success['status'] = $user->status;
            $success['number_phone'] = $user->number_phone;
            $success['device_token'] = $user->device_token;
   
            return $this->sendResponse($success, 'User login successfully.');
        } else { 
            $kosong = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            if($kosong->fails()) { 
                return $this->sendError(
                    'email atau password tidak boleh kosong',
                    ['error'=>'email atau password tidak boleh kosong']
                );
            }
    
            $exists = Validator::make($request->all(), [
                'email' => 'required|exists:users,email',
            ]);
    
            if($exists->fails()) { 
                return $this->sendError(
                    'Email tidak ditemukan, silahkan buat akun',
                    ['error'=>'Email tidak ditemukan, silahkan buat akun']
                );
            }

            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
