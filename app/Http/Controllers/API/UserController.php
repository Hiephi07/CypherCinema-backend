<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile () 
    {
        return $this->userService->profile(request()->header('Authorization'));
    }
}
