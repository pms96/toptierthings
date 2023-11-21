<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index() 
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request) 
    {
        $data = $request->validate([
            'id' => ['required', 'int'],
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['required', 'string', 'max:255'],
        ]);
        
        Role::create($data);
        
    }

    public function edit(int $id) 
    {
        $roles = Role::find($id);
        $permissions = Permission::all();
        $modules = array_unique($permissions->pluck('module')->toArray());
        return view('admin.roles.permissions', compact('roles','permissions','modules'));
    }

    public function update(Request $request, int $id) 
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id' => ['required', 'int'],
        ]);

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->update();

    }

    public function destroy(Request $request, $id) 
    {

        $request->validate([
            'id' => ['required', 'int'],
        ]);

        $role = Role::find($id);
        $role->delete();
        
    }
}
