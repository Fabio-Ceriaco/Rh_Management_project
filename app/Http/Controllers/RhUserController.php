<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RhUserController extends Controller
{
    public function index(): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $collaborators = User::where('role', 'rh')->get();

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
            ],
        );

        // create new rh user

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = 'rh';
        $user->department_id = $request->input('select_department');
        $user->permissions = '["rh"]';
        $user->save();

        return redirect()->route('rhcollaborators')->with('success', 'Collaborator created successfully.');
    }
}
