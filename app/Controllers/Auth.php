<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = service('authService');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (!$username || !$password) {
            return redirect()->back()
                ->with('error', 'All fields are required');
        }

        $result = $this->authService->attemptLogin($username, $password);

        if ($result['status']) {
            return redirect()->to('/dashboard');
        }

        return redirect()->back()
            ->with('error', $result['message']);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/');
    }
}