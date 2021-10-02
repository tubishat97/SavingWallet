<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function profile()
    {
        $administration = Auth::user();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Profile Update"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

        $selected_roles = $administration->roles->pluck('id')->toArray();

        return view('backend.administrations.show', compact('administration', 'breadcrumbs', 'pageConfigs', 'roles', 'selected_roles'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $user->username = $request->username;
            $user->save();

            $userProfile = $user->profile;
            $userProfile->fullname = trim($request->fullname);
            $userProfile->phone = trim($request->phone);

            if ($request->birthdate) {
                $dob = Carbon::createFromFormat('d/m/Y', $request->birthdate);
                $userProfile->birthdate = $dob->format('Y-m-d');
            }


            $userProfile->image = $request->hasFile('image') ? uploadFile('user', $request->file('image'), $userProfile->image) : $userProfile->image;
            $userProfile->save();

            return redirect()->route('admin.profile')->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "All Users"],
        ];
        
        $pageConfigs = ['pageHeader' => true];

        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'user');
            }
        )->get();

        return view('backend.administrations.list', compact('breadcrumbs', 'users', 'pageConfigs'));
    }

    public function destroy(User $administration)
    {
        if ($administration) {
            $administration->delete();
            return redirect(route('admin.administration.index'))->with('success', __('system-messages.delete'));
        }
    }
}
