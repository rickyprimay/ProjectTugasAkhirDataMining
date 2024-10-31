<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function register()
    {
        return view('Auth.register');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            Alert::error('Login Gagal', implode(', ', $errors));

            return redirect()->back()->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Alert::success('Success', 'Login Berhasil');

            return redirect()->route('dashboard');
        } else {
            Alert::error('Login Gagal', 'Email atau password salah');

            return redirect()->back()->withInput();
        }
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            Alert::error('Registrasi Gagal', implode(', ', $errors));

            return redirect()->back()->withInput();
        }

        if (User::where('email', $request->email)->first()) {
            Alert::error('Registrasi Gagal', 'Email Sudah Terdaftar');

            return redirect()->back()->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::login($user);

        Alert::success('Success', 'Kamu Berhasil Register');

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();

        Alert::success('Success', 'Kamu Berhasil Logout');

        return redirect()->route('login');
    }
}
