<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('admin/users/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() == 'post') {
            $userModel = new UserModel();
            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role')
            ];

            if ($userModel->insert($data)) {
                return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
            }
        }

        return view('admin/users/create');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        if ($this->request->getMethod() == 'post') {
            $updateData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role')
            ];

            if ($this->request->getPost('password')) {
                $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            if ($userModel->update($id, $updateData)) {
                return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui');
            }
        }

        return view('admin/users/edit', $data);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        if ($userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Gagal menghapus user');
    }
} 