<?php
namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function showPrompts()
    {
        $users = User::latest()->get(); // get all users/prompts
        return view('prompts.index', compact('users'));
    }
}
