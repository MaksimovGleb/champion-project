<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        $error = $request->session()->get('error');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($error)
            return to_route('user.login')->with('error', 'У вас нет ни одной роли.');
        return to_route('user.login');
    }
}
