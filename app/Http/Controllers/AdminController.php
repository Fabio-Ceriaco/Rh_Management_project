<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function home()
    {

        if (!Gate::allows('user_admin')) {
            abort(403, "You aren't authorized to access this page.");
        }

        // collect all information about the organization

        $data = [];

        // get total number of collaborators (delete_at is null)
        $data['total_collaborators'] = User::whereNull('deleted_at')->count();

        // total collaborators deleted
        $data['total_collaborators_deleted'] = User::onlyTrashed()->count();

        // total salary for all collaborators
        $data['total_salary'] = User::withoutTrashed()->with('detail')->get()->sum(function ($collaborator) {
            return $collaborator->detail->salary;
        });

        $data['total_salary'] = number_format($data['total_salary'], 2, ',', '.') . ' €';

        // total collaborators by department
        $data['total_collaborators_by_department'] = User::withoutTrashed()->with('department')->get()->groupBy('department_id')->map(function ($department) {
            return [
                'department' => $department->first()->department->name ?? '-',
                'total' => $department->count(),
            ];
        });

        // total salary by department
        $data['total_salary_by_department'] = User::withoutTrashed()->with('department', 'detail')->get()->groupBy('department_id')->map(function ($department) {
            return [
                'department' => $department->first()->department->name ?? '-',
                'total' => $department->sum(function ($collaborator) {
                    return $collaborator->detail->salary;
                }),
            ];
        });

        // format salary
        $data['total_salary_by_department'] = $data['total_salary_by_department']->map(function ($department) {
            return [
                'department' => $department['department'],
                'total' => number_format($department['total'], 2, ',', '.') . ' €',
            ];
        });
        return view('home', ['data' => $data]);
    }
}
