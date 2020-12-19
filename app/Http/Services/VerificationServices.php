<?php

namespace App\Http\Services;



use App\Models\User;
use App\Models\VerificationCodes;
use Illuminate\Support\Facades\Auth;

class VerificationServices
{


    public function setVerificationCode($data) {

        $code = mt_rand(100000, 999999);
        $data['code'] = $code;

        VerificationCodes::whereNotNull('user_id')->where(['user_id' => $data['user_id']])->delete();

        return VerificationCodes::create($data);
    }


    public function getSMSVerifyMessageByAppName($code)
    {
        $message = " is your verification code for your account";

        return $code.$message;    //" 658848 is your ver......."
    }


    public function checkOTPCode($code) {

        if(Auth::guard()->check()) {
            $logedInUserId = Auth::id();
            $verification_data = VerificationCodes::where('user_id', $logedInUserId)->first();

            if($verification_data->code == $code) {
                User::whereId($logedInUserId)->update(['verified_at' => now()]);
                return true;
            }else {
                return false;
            }
        }
        return false;
    }


    public function removeOTPCode($code) {
        VerificationCodes::where('code', $code)->delete();
    }

}
