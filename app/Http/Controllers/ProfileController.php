<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('user.profile');
    }

    public function changePassword(Request $request): RedirectResponse
    {

        // form validation

        $request->validate(
            [
                'current_password' => ['required', 'min:8', 'max:16'],
                'new_password' => ['required', 'min:8', 'max:16', 'different:current_password'],
                'new_password_confirmation' => ['required', 'same:new_password'],
            ]
        );

        $user = Auth::user();

        // check if the current password is correct

        if (!password_verify($request->input('current_password'), Auth::user()->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        };

        // update password in database
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
