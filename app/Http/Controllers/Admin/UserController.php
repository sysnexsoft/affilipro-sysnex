<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user.list', ['only' => ['index']]);
        $this->middleware('permission:user.store', ['only' => ['create', 'store']]);
        $this->middleware('permission:user.update', ['only' => ['update', 'edit']]);
        $this->middleware('permission:user.delete', ['only' => ['delete']]);
    }
    public function index(){
        $users = User::whereNotIn('id',[1])->get();
        $roles = Role::where('name', '!=', 'super-admin')->pluck('name', 'name')->all();
        return view('backEnd.user.index',compact('users','roles'));
    }
    public function store(Request $request){
        try {
            $input = array_merge($request->all(), [
                'password' => Hash::make($request->password),
            ]);
            $store = User::create($input);
            $store->syncRoles($request->role);
            return back()->with('success','User Create Successfully.');
        }
        catch (\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }
    public function update(Request $request, $id){
        try {
            $user = User::find($id);
            if ($request->password) {
                $n_pass = Hash::make($request->password);
            }

            $input = array_merge($request->all(), [
                'password' => $n_pass ?? $user->password,
            ]);

            $user->update($input);
            $user->syncRoles($request->role);
            return back()->with('success','User Updated Successfully.');
        }
        catch (\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        if (file_exists($user->avatar)){
            unlink($user->avatar);
        }
        $user->delete();
        return $user;
    }
}
