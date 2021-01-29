<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:users_index', ['only' => ['index']]);
        $this->middleware('permission:create_user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_user', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', __('notifications.success_create_product'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status
        ]);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', __('notifications.success_update_user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', __('notifications.success_delete_user'));
    }
}
