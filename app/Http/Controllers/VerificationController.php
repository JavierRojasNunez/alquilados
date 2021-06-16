<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class VerificationController extends Controller
{
    

public function verify($user_id, Request $request) {

    if (!$request->hasValidSignature()) {
        return response()->json(["msg" => "Invalid/Expired url provided."], 401);
    }

    
    $user = User::findOrFail($user_id);

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    
    if(!$user->hasVerifiedEmail()){
        return response()->json(["msg" => "Problems whith this verifycation, contact."], 400);
    }

   //aqui mandar respuesta o redirigir a vista return redirect()->to('/');
}

public function resend() {
    if (auth()->user()->hasVerifiedEmail()) {
        return response()->json(["msg" => "Email already verified."], 400);
    }

    auth()->user()->sendEmailVerificationNotification();

    return response()->json(["msg" => "Email verification link sent on your email id"]);
}


}
