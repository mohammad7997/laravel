<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\UserRepository;
use Dotenv\Loader\Resolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // validate of user
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        $user = resolve(UserRepository::class)->createUser($request);

        $defaultSuperAdmin = config('permission.default_super_admin_email');
        $user->email = $defaultSuperAdmin ? $user->assignRole('super admin') : $user->assignRole('user');

        return response()->json([
            "message" => 'user create successfully'
        ], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'login successfully',
            ], 200);
        }
        throw validationExeption::withMessage([
            'email' => 'incorrect credentials'
        ]);
    }

    /**
     * show user info login
     * @return \Illuminate\Http\JsonResponse
     */
    public function showInfoUser()
    {
        return response()->json([Auth::user()], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'user logged out successfully'
        ], 200);
    }


}
