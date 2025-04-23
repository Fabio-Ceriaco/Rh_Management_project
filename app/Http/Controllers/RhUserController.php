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

class RhUserController extends Controller
{
    public function index(): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $collaborators = User::withTrashed()->with('detail')->where('role', 'rh')->get();


        return view('collaborators.rh-users', ['collaborators' => $collaborators]);
    }

    public function newCollaborator(): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        // get all departments
        $departments = Department::all();

        return view('collaborators.add-rh-user', ['departments' => $departments]);
    }

    public function createCollaborator(Request $request): RedirectResponse
    {

        if (!Gate::allows('user_admin')) {
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
        if ($request->input('select_department') != 2) {
            return redirect()->route('home');
        }
        // create user confirmation toke
        $token = Str::random(64);

        // create new rh user

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->confirmation_token = $token;
        $user->role = 'rh';
        $user->department_id = $request->input('select_department');
        $user->permissions = '["rh"]';
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

        return redirect()->route('rhcollaborators')->with('success', 'Collaborator created successfully.');
    }

    public function editRhCollaborator($id): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);
        $collaborator = User::with('detail')->where('role', 'rh')->findOrFail($id);

        return view('collaborators.edit-rh-user', ['collaborator' => $collaborator]);
    }

    public function updateRhCollaborator(Request $request): RedirectResponse
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        // form validation

        $request->validate(
            [
                'user_id' => ['required', 'exists:users,id'],
                'salary' => ['required', 'decimal:2'],
                'admission_date' => ['required', 'date_format:Y-m-d'],
            ]
        );

        $user = User::findOrFail($request->input('user_id'));
        $user->detail->salary = $request->input('salary');
        $user->detail->admission_date = $request->input('admission_date');
        $user->detail->save();

        return redirect()->route('rhcollaborators')->with('success', "Collaborator updated successfully.");
    }

    public function deleteRhCollaborator($id): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);
        $collaborator = User::findOrFail($id);

        return view('collaborators.delete-rh-user', ['collaborator' => $collaborator]);
    }

    public function deleteRhCollaboratorConfirm($id)
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);
        $collaborator = User::findOrFail($id);

        $collaborator->delete();

        return redirect()->route('rhcollaborators');
    }

    public function restoreRhCollaborator($id)
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);
        $collaborator = User::withTrashed()->where('role', 'rh')->findOrFail($id);
        $collaborator->restore();

        return redirect()->route('rhcollaborators')->with('success', 'Collaborator restored successfully.');
    }
}
