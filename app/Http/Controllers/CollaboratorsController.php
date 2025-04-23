<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CollaboratorsController extends Controller
{
    public function index(): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $collaborators = User::withTrashed()->with('detail', 'department')->where('role', '<>', 'admin')->get();

        return view('collaborators.admin-all-collaborators')->with('collaborators', $collaborators);
    }

    public function showDetails($id): View|RedirectResponse
    {

        if (!Gate::allows('user_admin', 'user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        // check if id is the same as the auth user
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $collaborator = User::with('detail', 'department')->where('id', $id)->first();

        // check if collaborator exists
        if (!$collaborator) {
            abort(404);
        }

        return view('collaborators.show-details')->with('collaborator', $collaborator);
    }

    public function deleteCollaborator($id): View|RedirectResponse
    {

        if (!Gate::allows('user_admin', 'user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);

        // check if id is the same as the auth user
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $collaborator = User::findOrFail($id);

        return view('collaborators.delete-collaborator-confirm', ['collaborator' => $collaborator]);
    }

    public function deleteCollaboratorConfirm($id)
    {
        if (!Gate::allows('user_admin', 'user_rh')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);

        // check if id is the same as the auth user
        if (Auth::user()->id == $id) {
            return redirect()->route('home');
        }

        $collaborator = User::findOrFail($id);
        $collaborator->delete();

        return redirect()->route('all-collaborators');
    }

    public function restoreCollaborator($id)
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);
        $collaborator = User::withTrashed()->where('role', 'rh')->findOrFail($id);
        $collaborator->restore();

        return redirect()->route('all-collaborators')->with('success', 'Collaborator restored successfully.');
    }

    public function home(): View
    {

        if (!Gate::allows('user_collaborator')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $collaborator = User::with('detail', 'department')->find(Auth::user()->id);

        return view('collaborators.show-details')->with('collaborator', $collaborator);
    }
}
