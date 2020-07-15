<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserMainController extends Controller
{
    public function index(User $user){
        return view('user.userIndex');
    }
}
