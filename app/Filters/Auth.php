<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $admin = session()->get('admin');
        if (!$admin) {
            return redirect()->to('/login')
            ->with('error', 'Session habis, Silakan login kembali');
        }

        // Force password setup if the admin password is blank
        if (password_verify('', $admin['password'] ?? '')) {
            return redirect()->to('/setup-password');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
