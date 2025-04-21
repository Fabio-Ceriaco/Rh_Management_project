<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        if (Gate::allows('user_admin')) {
            $departments = Department::all();
            return view('department.departments', ['departments' => $departments]);
        } else {
            abort(403, "You aren't authorized to access this page.");
        };
    }

    public function newDepartment(): View
    {
        if (Gate::allows('user_admin')) {
            return view('department.add-department');
        } else {
            abort(403, "You aren't authorized to access this page.");
        }
    }

    public function storeDepartment(Request $request)
    {
        if (Gate::allows('user_admin')) {

            // form validation
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:50', 'unique:departments'],
                ]
            );

            Department::create(
                [
                    'name' => $request->input('name'),
                ],
            );

            return redirect()->route('departments');
        } else {
            abort(403, "You aren't authorized to access this page.");
        }
    }
}
