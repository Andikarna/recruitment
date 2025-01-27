<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function onboarding()
    {
        return view(view: 'onboarding');
    }
}
