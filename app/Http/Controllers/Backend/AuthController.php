<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SavePasswordRequest;
use App\Http\Requests\SaveChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'This email does not exist in our records.');
        }        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }
        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function profile()
    {
        return view('profile');
    }

    public function saveChangePassword(SaveChangePasswordRequest $request)
    {
        $user = Auth::user();
        
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
