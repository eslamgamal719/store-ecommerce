<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VerificationRequest;
use App\Http\Services\VerificationServices;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Request;

class VerificationCodeController extends Controller
{
    public $verificationService;

    public function __construct(VerificationServices $verificationService) {
        $this->verificationService = $verificationService;
    }



    public function verify(VerificationRequest $request)
    {
        $checkCode = $this->verificationService->checkOTPCode($request->code);

        if(!$checkCode) {
            return redirect()->route('get.verification.form')->withErrors(['code' => 'الكود غير صحيح']);
        }else {
           $this->verificationService->removeOTPCode($request->code);
            return redirect()->route('home');
        }
    }



    public function getVerifyPage() {
        return view('auth.verification');
    }
}
