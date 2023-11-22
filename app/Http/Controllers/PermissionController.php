<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index() 
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'id'            => ['required', 'int'],
            'name'          => ['required', 'string', 'max:255'],
            'module'        => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string', 'max:255'],
            'guard_name'    => ['required', 'string', 'max:255'],
        ]);
        
        Permission::create($data);
        
    }

    public function update(Request $request, $id) 
    {

        $request->validate([
            'id'            => ['required', 'int'],
            'name'          => ['required', 'string', 'max:255'],
            'module'        => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string', 'max:255'],
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->get('name');
        $permission->update();

    }

    public function destroy(Request $request, $id) 
    {

        $request->validate([
            'id' => ['required', 'int'],
        ]);

        $permission = Permission::find($id);
        $permission->delete();
        
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission_name)){
            echo 'Permiso existente';
            die;
        }
        $role->givePermissionTo($request->permission_name);
        echo 'Permiso Añadido';
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            echo 'Permiso Eliminado';
            die;
        }
        echo 'Permiso no existe';
    }
}
