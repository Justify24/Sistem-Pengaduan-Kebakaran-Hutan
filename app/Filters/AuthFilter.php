<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Dapatkan current path
        $currentPath = trim($request->getPath(), '/');
        
        // Jika user belum login
        if (!session()->get('isLoggedIn')) {
            // Jika mencoba mengakses halaman admin
            if (strpos($currentPath, 'admin') === 0) {
                // Kecuali untuk halaman login dan register
                if (!in_array($currentPath, ['admin/login', 'admin/register'])) {
                    return redirect()->to('/admin/login');
                }
            }
        }
        // Jika sudah login dan mencoba akses halaman login/register
        else {
            if (in_array($currentPath, ['admin/login', 'admin/register'])) {
                return redirect()->to('/admin/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
} 