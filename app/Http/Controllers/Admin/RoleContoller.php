<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class RoleContoller extends Controller
{
    public function index()
    {
        $adminCount = User::role('Admin')->count();
        $managerCount = User::role('Manager')->count();
        $userCount = Employee::count();

        return view('admin.roles.index', compact('adminCount', 'managerCount', 'userCount'));
    }
}
