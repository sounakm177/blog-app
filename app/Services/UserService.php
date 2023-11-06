<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getAllUser()
    {
        return User::get();
    }

    public function getAllUsersExceptMe()
    {
        return User::where('id', '!=', Auth::id())->get();
    }
}