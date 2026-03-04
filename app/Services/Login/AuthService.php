<?php

namespace App\Services\Login;

use App\Models\UserModel;

class AuthService
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function attemptLogin($username, $password)
    {
        $user = $this->model
            ->where('username', $username)
            ->first();

        // Plain text comparison (NOT secure)
        if (!$user || $password !== $user['password']) {
            return [
                'status' => false,
                'message' => 'Invalid username or password'
            ];
        }

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'isLoggedIn' => true
        ]);

        return ['status' => true];
    }

    public function logout()
    {
        session()->destroy();
    }
}