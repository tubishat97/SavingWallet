<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();

        $usersCount = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'user');
            }
        )->count();

        if ($user->hasRole('user')) {
            $thisYear = Carbon::now()->format('Y');
            $thisYearIncome = [];
            $thisYearExpenses = [];
            $months = allMonths(); // From helper.

            foreach ($months as $value) {
                $thisYearIncome[$value] =  $user->income()->whereYear('created_at', $thisYear)->whereMonth('created_at', $value)->sum('amount');
                $thisYearExpenses[$value] =  $user->expenses()->whereYear('created_at', $thisYear)->whereMonth('created_at', $value)->sum('amount');
            }

            return view('backend.user-dashboard', compact('user', 'thisYearIncome', 'thisYearExpenses', 'thisYear'));
        }

        return view('backend.dashboard', compact('usersCount'));
    }
}
