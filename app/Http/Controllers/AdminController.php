<?php

namespace App\Http\Controllers;

use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }

  public function showUsers()
  {
    $users = User::where('id', '!=', Auth::user()->id)
      ->paginate(10);
    return view('admin.users')->with(['users' => $users]);
  }

  public function createUser(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'username' => 'required|unique:users',
      'password' => 'required',
      'access_level' => 'required'
    ]);

    User::create([
      'name' => $request->input('name'),
      'username' => $request->input('username'),
      'password' => Hash::make($request->input('password')),
      'access_level' => $request->input('access_level'),
    ]);

    session()->flash('success', 'User successfully created!');
    return redirect('/admin/users');
  }

  public function editUser(Request $request, $id)
  {
    User::where('id', $id)
      ->update([
        'name' => $request->input('name'),
        'username' => $request->input('username'),
        'password' => Hash::make($request->input('password')),
        'access_level' => $request->input('access_level'),
      ]);

    session()->flash('success', 'User successfully updated!');
    return redirect('/admin/users');
  }

  public function deleteUser($id)
  {
    $user = User::destroy($id);
    return redirect('/admin/users');
  }
}
