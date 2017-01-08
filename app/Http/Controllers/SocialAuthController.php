<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccountService;

class SocialAuthController extends Controller
{
    // redirect function
    public function redirect(){
        return Socialite::driver('facebook')->redirect();
    }
    // callback function
    public function callback(SocialAccountService $service){
        // when facebook call us a with token
    }
}
