<?php

namespace App\Http\Services;



use App\Models\VerificationCodes;

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


        return $code.$message;
    }

}
