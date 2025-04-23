<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RhManagementContoller extends Controller
{
    public function home(): View
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You are not authorized to access this page.");
        }

        $collaborators = User::with('detail', 'department')->where('role', 'collaborator')->withTrashed()->get();

        return view('collaborators.collaborators', ['collaborators' => $collaborators]);
    }

    public function newCollaborator(): View
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You are not authorized to access this page.");
        }

        $departments = Department::where('id', '>', 2)->get();

        // if there are no departments, abort request
        if ($departments->count() == 0) {
            abort(403, "There are no departments to add a new collaborator. Please contact the system administrator to add new department.");
        }

        return view('collaborators.add-collaborators')->with('departments', $departments);
    }

    public function storeCollaborator(Request $request): View|RedirectResponse
    {
        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }


        // form validation

        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'select_department' => ['required', 'exists:departments,id'],
                'address' => ['required', 'string', 'max:255'],
                'zip_code' => ['required', 'string', 'max:10'],
                'city' => ['required', 'string', 'max:50'],
                'phone' => ['required', 'string', 'max:50'],
                'salary' => ['required', 'decimal:2'],
                'admission_date' => ['required', 'date_format:Y-m-d'],
            ],
        );

        // check if department id is equal to 2
        if ($request->input('select_department') <= 2) {
            return redirect()->route('home');
        }
        // create user confirmation toke
        $token = Str::random(64);

        // create new rh user

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->confirmation_token = $token;
        $user->role = 'collaborator';
        $user->department_id = $request->input('select_department');
        $user->permissions = '["collaborator"]';
        $user->save();

        // save user details

        $user->detail()->create([
            'address' => $request->input('address'),
            'zip_code' => $request->input('zip_code'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'salary' => $request->input('salary'),
            'admission_date' => $request->input('admission_date'),
        ]);
        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('rhcollaborators.managementHome')->with('success', 'Collaborator created successfully.');
    }

    public function editCollaborator($id): View
    {
        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);
        $collaborator = User::with('detail', 'department')->findOrFail($id);
        $departments = Department::where('id', '>', 2)->get();
        return view('collaborators.edit-collaborator', ['collaborator' => $collaborator, 'departments' => $departments]);
    }

    public function updateCollaborator(Request $request): View|RedirectResponse
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        // form validation

        $request->validate(
            [
                'user_id' => ['required', 'exists:users,id'],
                'salary' => ['required', 'decimal:2'],
                'admission_date' => ['required', 'date_format:Y-m-d'],
                'select_department' => ['required', 'exists:departments,id'],
            ]
        );

        // check if department is valid
        if ($request->input('select_department') <= 2) {
            return redirect()->route('home');
        }

        $user = User::with('detail')->findOrFail($request->input('user_id'));
        $user->detail->salary = $request->input('salary');
        $user->detail->admission_date = $request->input('admission_date');
        $user->department_id = $request->input('select_department');
        $user->detail->save();
        $user->save();

        return redirect()->route('rhcollaborators.managementHome')->with('success', "Collaborator updated successfully.");
    }

    public function showCollaboratorDetails($id): View
    {
        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        $collaborator = User::with('detail', 'department')->findOrFail($id);

        return view('collaborators.show-collaborator-details', compact('collaborator'));
    }

    public function deleteCollaborator($id): View
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        $collaborator = User::findOrFail($id);

        return view('collaborators.delete-collaborators', compact('collaborator'));
    }

    public function deleteCollaboratorConfirm($id): RedirectResponse
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        $collaborator = User::findOrFail($id);

        $collaborator->delete();

        return redirect()->route('rhcollaborators.managementHome');
    }

    public function restoreCollaborator($id): RedirectResponse
    {

        if (!Gate::allows('user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        $collaborator = User::withTrashed()->findOrFail($id);

        $collaborator->restore();

        return redirect()->route('rhcollaborators.managementHome');
    }
}
