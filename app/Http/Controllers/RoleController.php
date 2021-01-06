<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles_index', ['only' => ['index']]);
        $this->middleware('permission:show_role', ['only' => ['show']]);
        $this->middleware('permission:create_role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $permissions = array_keys($request->permissions);
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();
        // return $rolePermissions;
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        // dd($rolePermissions);
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $selected_permissions = array_keys($request->permissions);
        $role->syncPermissions($selected_permissions);
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
