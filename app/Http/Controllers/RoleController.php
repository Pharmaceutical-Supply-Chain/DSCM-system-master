<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //

    public function index ()
    {
        return RoleResource::collection(
            Role::where('role_id', '1')->get()
        );
    }
}
