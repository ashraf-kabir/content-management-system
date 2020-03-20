<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Users\UpdateProfileRequest;

class UsersController extends Controller
{
    public function index() {
        return view('users.index')->with('users', User::all());
    }

    public function update(UpdateProfileRequest $request) {
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'about' => $request->about
        ]);

        session()->flash('success', 'User updated successfully.');

        return redirect()->back();
    }

    public function edit() {
        return view('users.edit')->with('user', auth()->user());
    }

    public function makeAdmin(User $user) {
        $user->role = 'admin';

        $user->save();

        session()->flash('success', 'User role changed to ADMIN.');

        return redirect(route('users.index'));
    }

    public function destroy($id) {

        if (auth()->user()->id == $id) {
            session()->flash('error', 'You do not have permission.');
            return redirect()->back();
        } else {
            User::destroy($id);

            session()->flash('success', 'User deleted successfully.');
    
            return redirect(route('users.index'));
        }
    }
}
