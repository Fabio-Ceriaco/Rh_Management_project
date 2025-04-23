<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $collaborator = User::with('detail', 'department')->findOrFail(Auth::user()->id);
        return view('user.profile', ['collaborator' => $collaborator]);
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

    public function changeUserData(Request $request): RedirectResponse
    {
        // form validation
        $request->validate(
            [
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            ]
        );

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->back()->with('success_change_data', "User data updated successfully.");
    }

    public function changeUserAddress(Request $request): RedirectResponse
    {

        // form validation

        $request->validate(
            [
                'address' => ['required', 'min:3', 'max:100'],
                'city' => ['required', 'min:3', 'max:50'],
                'zip_code' => ['required', 'min:3', 'max:10'],
                'phone' => ['required', 'min:3', 'max:20'],

            ],
        );

        $user = User::with('detail')->find(Auth::user()->id);

        $user->detail->address = $request->input('address');
        $user->detail->city = $request->input('city');
        $user->detail->zip_code = $request->input('zip_code');
        $user->detail->phone = $request->input('phone');
        $user->detail->save();

        return redirect()->back()->with('success_change_address', "User address updated successfully.");
    }
}
