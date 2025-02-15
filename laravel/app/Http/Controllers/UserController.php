<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class UserController extends Controller
{

    #[Get('/home')]
    public function getUser()
    {
        return view('user');
    }
}
