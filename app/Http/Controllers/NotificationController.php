<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;

class NotificationController extends BaseController
{
    public function saveToken(Request $request)
    {   
        $id = auth()->user()->id;
        $success = User::find($id)->update([
            'device_token' => $request->device_token,
        ]);
        return $this->sendResponse($success, "Successfully saved token");
    }

    public function getToken(Request $request)
    {   
        $success = User::select('device_token')->where('id', $request->id)->first();
        
        return $this->sendResponse($success, "Successfully saved token");
    }

    public function sendNotification(Request $request)
    {
        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->toarray();

        $SERVER_API_KEY = "AAAAVeui5y0:APA91bHh4ymJj22nlBj-7mYq46XQfcpUscs2_05LqlaAX23Gj0qsFXxq1qYxxo6svFW4p4X-ME9aNqsZCxp8yVnwkMuYtzPrEzJ8-ehTB639UdJyP3-OdFz_Gg2o1QdP0tXqsY_KhUg_";

        $data = [
            "registration_ids" => [$request->device_token],
            "data" => [
                "body" => $request->body,  
                "title" => "Pesan Masuk"
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);

        $success = curl_exec($curl);

        return $this->sendResponse($success, "Successfully saved token");
        
    }
}
