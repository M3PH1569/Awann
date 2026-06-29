<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PerangkatModel;
use App\Models\MutasiModel;
use Config\Database;
use Config\Services;

class AdminController extends BaseController
{
    protected $perangkatModel;
    protected $mutasiModel;
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->perangkatModel = new PerangkatModel();
        $this->mutasiModel = new MutasiModel();
        $this->db = Database::connect();

        $this->session = Services::session();
        helper('form');
    }

    public function index()
    {
        return view('login');
    }

    public function login()
    {
        helper('logsecurity');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $safeUsername = sanitizeLog((string) $username);

        $admin = $this->db->table('admin')->where('username', $safeUsername)->get()->getRowArray();
        if ($admin && password_verify($password, $admin['password'])) {
            $this->session->set('admin', $admin);
            log_message('info', 'Login berhasil username: ' . $safeUsername);
            // If password is blank, redirect to setup page before dashboard
            if (password_verify('', $admin['password'])) {
                return redirect()->to('/setup-password');
            }
            return redirect()->to('/dashboard');
        } else {
            log_message('warning', 'Login gagal username: ' . $safeUsername);
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }

    public function setupPassword()
    {
        $adminSession = session()->get('admin');

        if (!$adminSession || !isset($adminSession['id'])) {
            return redirect()->to('/login');
        }

        // If password is already set, go straight to dashboard
        $adminDb = $this->db->table('admin')->where('id', $adminSession['id'])->get()->getRowArray();
        if (!password_verify('', $adminDb['password'])) {
            return redirect()->to('/dashboard');
        }

        if (strtolower($this->request->getMethod()) === 'post') {
            $newPass  = trim($this->request->getPost('new_password'));
            $confPass = trim($this->request->getPost('confirm_password'));

            if (empty($newPass)) {
                return redirect()->back()->with('error', 'Password baru harus diisi.');
            }
            if (strlen($newPass) < 5) {
                return redirect()->back()->with('error', 'Password baru harus minimal 5 karakter.');
            }
            if ($newPass !== $confPass) {
                return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
            }

            $this->db->table('admin')->where('id', $adminSession['id'])->update([
                'password'   => password_hash($newPass, PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            // Destroy the session and force fresh login
            $this->session->destroy();
            return redirect()->to('/login')->with('success', 'Password berhasil diatur. Silakan login dengan password baru.');
        }

        return view('setup_password');
    }

    public function updatePassword()
    {
        $adminSession = session()->get('admin');

        if (!$adminSession || !isset($adminSession['id'])) {
            return redirect()->back()->with('error', 'Sesi tidak ditemukan, silakan login ulang.');
        }

        $adminId = $adminSession['id'];

        $oldPass  = trim($this->request->getPost('current_password'));
        $newPass  = trim($this->request->getPost('new_password'));
        $confPass = trim($this->request->getPost('confirm_password'));

        if (empty($oldPass) || empty($newPass)) {
            return redirect()->back()->with('error', 'Semua field password harus diisi.')->with('openModal', true);
        }

        $adminDb = $this->db->table('admin')->where('id', $adminId)->get()->getRowArray();

        if (!password_verify($oldPass, $adminDb['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai. Silakan cek kembali.')->with('openModal', true);
        }

        if (strlen($newPass) < 5) {
            return redirect()->back()->with('error', 'Password baru harus minimal 5 karakter.')->with('openModal', true);
        }

        if ($oldPass === $newPass) {
            return redirect()->back()->with('error', 'Password baru tidak boleh sama dengan password lama.')->with('openModal', true);
        }

        if ($newPass !== $confPass) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok.')->with('openModal', true);
        }

        $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);

        $update = $this->db->table('admin')->where('id', $adminId)->update([
            'password' => $hashedPassword
        ]);

        if ($update) {
            // Destroy session and force fresh login
            $this->session->destroy();
            return redirect()->to('/login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui database.')->with('openModal', true);
    }
}