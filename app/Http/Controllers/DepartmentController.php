<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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

    public function storeDepartment(Request $request): RedirectResponse
    {
        if (Gate::allows('user_admin')) {

            // form validation
            $request->validate(
                [
                    'name' => ['required', 'string', 'min:3', 'max:50', 'unique:departments'],
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

    public function editDepartment(string $id): View|RedirectResponse
    {
        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($id);

        // check if id equals 1
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.edit-department', ['department' => $department]);
    }

    public function updateDapartment(Request $request): View|RedirectResponse
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        $id = Crypt::decryptString($request->input('id'));

        // check if id is equal to 1
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }
        // form validation
        $request->validate([
            'id' => ['required'],
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:departments'],
        ]);

        $department = Department::findOrFail($id);

        $department->name = $request->input('name');
        $department->save();

        return redirect()->route('departments');
    }

    public function deleteDepartment($id): View|RedirectResponse
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);
        // check if id is equal to 1
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        // display page for confrimation

        return view('department.delete-department-confirm', ['department' => $department]);
    }

    public function deleteDepartmentConfirm($id): RedirectResponse
    {
        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }
        $id = Crypt::decryptString($id);
        // check if id is equal to 1
        if ($this->isDepartmentBlocked($id)) {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->route('departments');
    }

    private function isDepartmentBlocked($id)
    {

        return in_array(intval($id), [1, 2]);
    }
}
