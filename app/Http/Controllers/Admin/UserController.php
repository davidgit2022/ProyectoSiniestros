<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        $adminCount = User::role('Admin')->count();
        $managerCount = User::role('Perito')->count();
        $userCount = User::role('Taller')->count();

        return $dataTable->render('admin.users.index', compact('adminCount', 'managerCount', 'userCount'));
    }

    public function create()
    {
		
		$roles = Role::query()->get();
         
        return view('admin.users.create')->with(compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
		//dd($input );
		$rol_s = $request->input('rol');
        $user = User::create( $input );
        $user->assignRole($rol_s);

        return Redirect::route('admin.users.index')->withSuccess('Registro guardado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $input = $request->all();
        $input['password'] = !empty($request->password) ? bcrypt($request->password) : $user->password;

        $user->update( $input );

        return Redirect::route('admin.users.index')->withSuccess('Registro actualizado con éxito.');
    }

    public function destroy(User $user)
    {
        $user->update([
            'active' => false
        ]);

        return Redirect::route('admin.users.index')->withSuccess('Registro eliminado con éxito.');
    }
}
