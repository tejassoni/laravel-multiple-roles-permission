<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Role; // KEY : MULTIPERMISSION
use Spatie\Permission\Models\Permission; // KEY : MULTIPERMISSION

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->view('users.index', [
            'users' => User::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $roleIds = Role::whereIn('name', $request->roles)->pluck('id')->toArray();
            $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
            $user->assignRole($roleIds); // new roles assigned to user  
            return redirect()->route('users.index')
                ->withSuccess('Created Successfully...!');
        } catch (\Exception $ex) {
            return redirect()->route('users.create')
                ->withError('Fail to update...!, ' . $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return response()->view('users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $roleIds = Role::whereIn('name', $request->roles)->pluck('id')->toArray();
            $user->roles()->detach(); // remove older roles assigned to user   
            $user->assignRole($roleIds); // new roles assigned to user   
            return redirect()->route('users.index')
                ->withSuccess('Updated Successfully...!');
        } catch (\Exception $ex) {
            return redirect()->route('users.index')
                ->withError('Fail to update...!, ' . $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('Deleted Successfully.');
    }
}
