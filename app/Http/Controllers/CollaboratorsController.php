<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CollaboratorsController extends Controller
{
    public function index(): View
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $collaborators = User::with('detail', 'department')->where('role', '<>', 'admin')->get();

        return view('collaborators.admin-all-collaborators')->with('collaborators', $collaborators);
    }
}
