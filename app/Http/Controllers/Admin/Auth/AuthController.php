<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];

        return view('backend.auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function showRegisterForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];

        return view('backend.auth.register', ['pageConfigs' => $pageConfigs]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = new User($request->all());
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();

            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->fullname = trim($request->fullname);
            $userProfile->phone = trim($request->phone);

            if ($request->dob) {
                $dob = Carbon::createFromFormat('d/m/Y', $request->dob);
                $userProfile->birthdate = $dob->format('Y-m-d');
            }

            $userProfile->image = $request->hasFile('image') ? uploadFile('user', $request->file('image')) : null;
            $userProfile->save();

            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->save();

            $user->assignRole('user');
            $user->save();

            Auth::login($user);

            return redirect()->intended(route('admin.dashboard'));
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function login(LoginRequest $request)
    {
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors(['username' => 'Email or password is incorrect']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect(route('admin.login_form'));
    }
}
