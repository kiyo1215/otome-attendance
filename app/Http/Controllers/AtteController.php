<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AtteController extends Controller
{
    public function login()
    {
        return view('atte.login');
    }
}
