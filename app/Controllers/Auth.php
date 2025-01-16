<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        // Validasi input
        $rules = [
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // Simpan data user
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/admin/login');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        // Validasi input
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password harus diisi');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: cek apakah username ada
        $user = $this->userModel->where('username', $username)->first();
        
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan');
        }

        // Debug: cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        // Jika berhasil login
        $sessionData = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'isLoggedIn' => true
        ];

        session()->set($sessionData);
        
        // Debug: cek session
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Gagal membuat session');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('message', 'Anda telah berhasil logout');
    }
} 