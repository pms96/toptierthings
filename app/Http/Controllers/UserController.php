<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(20);

        return view('admin.user.index', compact('users'));
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
        ])->assignRole('user');

        Session::flash('success', 'User created successfully');
        return redirect()->back();
    }

    public function edit(User $user){
        $roles = Role::all();
        
        return view('admin.user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email, $user->id",
            'password' => 'sometimes|nullable|min:8',
            'role' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->description = $request->description;
        $user->save();
        
        if ($user->hasRole($request->role) ||  (isset($user->Roles[0]) && $user->hasRole($user->Roles[0]['name'])) ) {
            $user->removeRole($request->role);
            $user->removeRole($user->Roles[0]['name']);
        }

        $user->assignRole($request->role);

        Session::flash('success', 'User updated successfully');
        return redirect()->back();
    }

    public function destroy(User $user){
        if($user){
            $user->delete();
            Session::flash('success', 'User deleted successfully');
        }
        return redirect()->back();
    }

    public function profile(){
        $user = auth()->user();

        return view('admin.user.profile', compact('user'));
    }

    public function profile_update(Request $request){
        $user = auth()->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email, $user->id",
            'password' => 'sometimes|nullable|min:8',
            'image'=> 'sometimes|nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->description = $request->description;

        if($request->has('password') && $request->password !== null){
            $user->password = bcrypt($request->password);
        }

        if($request->hasFile('image')){
            $image = $request->image;
            $image_new_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('storage/user/', $image_new_name);
            $user->image = '/storage/user/' . $image_new_name;
        }
        $user->save();

        Session::flash('success', 'User profile updated successfully');
        return redirect()->back();
    }

    function updateRoles (Request $request, User $user) {

        $request->validate([
            'role_id' => ['required', 'int'],
            'role_name' => ['required', 'string', 'max:255'],
            'model_id' => ['required', 'int'],
        ]);
        
        if ($user->hasRole($request->role_name) ||  (isset($user->Roles[0]) && $user->hasRole($user->Roles[0]['name'])) ) {
            $user->removeRole($request->role_name);
            $user->removeRole($user->Roles[0]['name']);
        }

        $user->assignRole($request->role_name);

        
        return 'Rol Actualizado';
        
    }
}
