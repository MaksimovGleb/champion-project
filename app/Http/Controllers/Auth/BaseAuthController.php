<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;

class BaseAuthController extends Controller
{
    protected function setActiveRole()
    {
        $roleDefault = Auth::user()->roles->sortByDesc('priority')->first();
        Auth::user()->setActiveRole($roleDefault);
    }
}
