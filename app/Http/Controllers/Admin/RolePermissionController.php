<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role.permission', ['only' => ['index']]);
        $this->middleware('permission:role.permission.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role.permission.edit', ['only' => ['update', 'edit']]);
        $this->middleware('permission:role.permission.delete', ['only' => ['delete']]);
    }

    public function index(){
        $role_permissions = Role::with('permissions')->where('name', '!=', 'super-admin')->get();
        // dd($role_permissions);
        $permissions = Permission::get();
        return view('backEnd.role-permission.index',compact('role_permissions','permissions'));
    }
    public function create()
    {
        DB::statement("SET SQL_MODE=''");
        $permissions = DB::table('permissions')->get();

        $array = $permissions->groupBy(function ($item) {
            return Str::before($item->name, '.');
        })->toArray();
        //dd($array);
        return view('backEnd.role-permission.create', compact('permissions', 'array'));
    }
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            // 'permissions' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        // $role->syncPermissions($request->input('permissions'));
        $role->syncPermissions($request->permission);

        return redirect()->route('admin.role.permission')->with('success', 'Role Created Successfully');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        DB::statement("SET SQL_MODE=''");
        $permissions = DB::table('permissions')->get();

        $array = $permissions->groupBy(function ($item) {
            return Str::before($item->name, '.');
        })->toArray();

        $role_permissions = $role->permissions->pluck('id')->toArray();
        //dd($role_permissions);

        return view('backEnd.role-permission.edit', compact('permissions', 'role', 'array', 'role_permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'permissions' => 'required',
        ]);
        //dd($request->all());

        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permission);

        return redirect()->route('admin.role.permission')->with('success', 'Role Updated Successfully');
    }

    public function delete(Request $request)
    {
        $role = Role::find($request->id)->delete();
        return $role;
    }
}
