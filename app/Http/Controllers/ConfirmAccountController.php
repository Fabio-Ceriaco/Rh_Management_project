<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfirmAccountController extends Controller
{
    public function confirmAccount($url): View
    {
        // check if the token is valid

        $user = User::where('confirmation_token', $url)->first();

        if (!$user) {
            abort(403, 'Invalid confirmation token.');
        }


        return view('auth.confirm-account', ['user' => $user]);
    }

    public function confirmAccountSubmit(Request $request): View
    {

        // form validation
        $request->validate(
            [
                'token' => ['required', 'string', 'size:64'],
                'password' => ['required', 'min:8', 'confirmed', 'max:16', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ],
        );

        $user = User::where('confirmation_token', $request->input('token'))->first();

        $user->password = bcrypt($request->input('password'));
        $user->confirmation_token = null;
        $user->email_verified_at = Carbon::now();
        $user->save();

        return view('auth.welcome', ['user' => $user]);
    }
}
