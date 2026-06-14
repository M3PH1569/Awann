<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PerangkatModel;
use App\Models\MutasiModel;
use App\Models\UserModel;
use Config\Database;
use Config\Services;

class DashboardController extends BaseController
{
    protected $perangkatModel;
    protected $mutasiModel;
    protected $userModel;

    public function __construct()
    {
        $this->perangkatModel = new PerangkatModel();
        $this->mutasiModel = new MutasiModel();
        $this->userModel = new UserModel();
    }

    public function dashboard()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = 50;
        $offset = ($page - 1) * $limit;
        $filters = [
            'keyword' => $this->request->getGet('keyword'),
            'status' => $this->request->getGet('status'),
            'filter_mutasi' => $this->request->getGet('filter_mutasi'),
            'user' => $this->request->getGet('user'),
            'sort_by' => $this->request->getGet('sort_by'),
            'sort_dir' => $this->request->getGet('sort_dir'),
        ];

        $result = $this->perangkatModel->getDataDash($filters, $limit, $offset);

        $data['perangkat'] = $result['data'];
        $totalData = $result['total'];
        $data['currentPage'] = $page;
        $data['limit'] = $limit;
        $data['totalPage'] = ceil($totalData / $limit);

        $configMutasi = new \Config\Mutasi();
        $data['statuses'] = $configMutasi->status;

        $userModel = new \App\Models\UserModel();
        $data['users'] = $userModel->orderBy('nama', 'ASC')->findAll();

        return view('dashboard', $data);
    }

    public function getHistory($id)
    {
        $model = new \App\Models\MutasiModel();

        $page = $this->request->getVar('page') ?? 1;
        $search = $this->request->getVar('searchHistory') ?? '';

        $limit = 15;
        $offset = ($page - 1) * $limit;

        $filters = [
            'searchHistory' => $search
        ];

        $result = $model->getDataHistory($id, $filters, $limit, $offset);

        $total = $result['total'];
        $totalPage = ceil($total / $limit);

        return $this->response->setJSON([
            'data' => $result['data'],
            'total' => $total,
            'totalPage' => $totalPage,
            'currentPage' => (int) $page
        ]);
    }

    public function checkMutasi($id)
    {
        $mutasi = $this->mutasiModel->find($id);

        if (!$mutasi || !in_array($mutasi['status'], ['Terpasang', 'Terkirim'])) {
            return $this->response->setJSON(['success' => false]);
        }

        $this->mutasiModel->update($id, [
            'is_checked' => 1,
            'checked_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    public function simpanPerangkat()
    {
        $idSpecInput = $this->request->getPost('id_spec');
        $namaInput = $this->request->getPost('nama');
        $kodeId = $this->request->getPost('kode_id');

        $data = [
            'kode_id' => $kodeId,
            'status' => 'Tersedia',
        ];

        if (is_numeric($idSpecInput)) {
            $data['id_spec'] = (int) $idSpecInput;
            $data['nama'] = $namaInput;
        } else {
            $data['id_spec'] = null;
            $data['nama'] = $idSpecInput;
        }

        if ($this->perangkatModel->insert($data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil ditambahkan']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan data']);
    }

    public function userList()
    {
        $db = \Config\Database::connect();
        $users = $db->table('users')->orderBy('nama', 'ASC')->get()->getResultArray();
        return $this->response->setJSON($users);
    }

    public function addUser()
    {
        try {
            $nama = trim($this->request->getPost('nama'));

            if (!$nama) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Nama tidak boleh kosong'
                ]);
            }

            $db = \Config\Database::connect();

            $insert = $db->table('users')->insert([
                'nama' => $nama
            ]);

            if (!$insert) {
                return $this->response->setJSON([
                    'success' => false,
                    'db_error' => $db->error()
                ]);
            }

            $insertID = $db->insertID();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'id' => $insertID,
                    'nama' => $nama
                ]
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteUser($id)
    {
        $db = \Config\Database::connect();

        $deleted = $db->table('users')->delete(['id' => $id]);
        return $this->response->setJSON([
            'success' => $deleted ? true : false
        ]);
    }

    public function updateUser($id)
    {
        $nama = trim($this->request->getPost('nama'));

        if (!$nama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama tidak boleh kosong'
            ]);
        }

        $db = \Config\Database::connect();

        $db->table('users')->where('id', $id)->update([
            'nama' => $nama
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    // ── Admin Manage ────────────────────────────────────────────────────────

    public function adminList()
    {
        $adminSession = session()->get('admin');
        $isSuper = $adminSession && ((isset($adminSession['is_super']) && $adminSession['is_super'] == 1) || $adminSession['username'] === 'admin');
        if (!$isSuper) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        $db = \Config\Database::connect();
        $admins = $db->table('admin')->select('id, nama, username')->get()->getResultArray();
        return $this->response->setJSON($admins);
    }

    public function addAdmin()
    {
        $adminSession = session()->get('admin');
        $isSuper = $adminSession && ((isset($adminSession['is_super']) && $adminSession['is_super'] == 1) || $adminSession['username'] === 'admin');
        if (!$isSuper) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        $db   = \Config\Database::connect();
        $nama     = trim($this->request->getPost('nama'));
        $username = trim($this->request->getPost('username'));

        if (!$nama || !$username) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Nama dan Username wajib diisi']);
        }

        // Check duplicate username
        $exist = $db->table('admin')->where('username', $username)->get()->getRowArray();
        if ($exist) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Username sudah digunakan']);
        }

        $db->table('admin')->insert([
            'nama'       => $nama,
            'username'   => $username,
            'password'   => password_hash('', PASSWORD_DEFAULT),
            'is_super'   => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    public function deleteAdmin($id)
    {
        $adminSession = session()->get('admin');
        $isSuper = $adminSession && ((isset($adminSession['is_super']) && $adminSession['is_super'] == 1) || $adminSession['username'] === 'admin');
        if (!$isSuper) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        // Prevent self-deletion
        if ($adminSession && $adminSession['id'] == $id) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Tidak dapat menghapus akun sendiri']);
        }

        $db = \Config\Database::connect();
        $db->table('admin')->delete(['id' => $id]);

        return $this->response->setJSON(['success' => true]);
    }

    // ── Return Requests ──────────────────────────────────────────────────────

    public function getPendingReturns()
    {
        $adminSession = session()->get('admin');
        if (!$adminSession) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        $returnRequestModel = new \App\Models\ReturnRequestModel();
        $requests = $returnRequestModel->getPendingRequestsGrouped();

        return $this->response->setJSON(['success' => true, 'data' => $requests]);
    }

    public function approveReturnGroup()
    {
        $adminSession = session()->get('admin');
        if (!$adminSession) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        $approvedIds = $this->request->getPost('approved_ids');
        $rejectedIds = $this->request->getPost('rejected_ids');
        
        if (empty($approvedIds) && empty($rejectedIds)) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Tidak ada perangkat yang dipilih.']);
        }

        $approvedIds = is_array($approvedIds) ? $approvedIds : [];
        $rejectedIds = is_array($rejectedIds) ? $rejectedIds : [];

        $returnRequestModel = new \App\Models\ReturnRequestModel();
        $mutasiModel = new \App\Models\MutasiModel();
        $perangkatModel = new \App\Models\PerangkatModel();

        $db = \Config\Database::connect();
        $db->transStart();

        // Process Approved Requests
        foreach ($approvedIds as $requestId) {
            $request = $returnRequestModel->find($requestId);
            if (!$request || $request['status'] !== 'Pending') {
                continue;
            }

            // Update return_requests status
            $returnRequestModel->update($requestId, ['status' => 'Approved']);

            // Insert new mutasi status to preserve history
            $mutasiId = $request['id_mutasi'];
            $mutasi = $mutasiModel->find($mutasiId);
            
            if ($mutasi) {
                $mutasiModel->insert([
                    'id_perangkat' => $mutasi['id_perangkat'],
                    'id_users'     => $mutasi['id_users'],
                    'status'       => 'Kembali',
                    'keterangan'   => '-'
                ]);
                
                // Update perangkat status to Tersedia
                $perangkatId = $mutasi['id_perangkat'];
                $perangkatModel->update($perangkatId, ['status' => 'Tersedia']);
            }
        }

        // Process Rejected Requests
        foreach ($rejectedIds as $requestId) {
            $request = $returnRequestModel->find($requestId);
            if (!$request || $request['status'] !== 'Pending') {
                continue;
            }

            // Reject the return request, device remains 'Dibawa'
            $returnRequestModel->update($requestId, ['status' => 'Rejected']);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Gagal memproses request pengembalian.']);
        }

        return $this->response->setJSON(['success' => true, 'msg' => 'Data pengembalian berhasil diproses.']);
    }

    public function markReturnRead()
    {
        $adminSession = session()->get('admin');
        if (!$adminSession) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'msg' => 'Akses ditolak.']);
        }

        $requestIds = $this->request->getPost('request_ids');
        if (empty($requestIds) || !is_array($requestIds)) {
            return $this->response->setJSON(['success' => false, 'msg' => 'Request ID tidak valid.']);
        }

        $returnRequestModel = new \App\Models\ReturnRequestModel();
        
        foreach ($requestIds as $id) {
            $returnRequestModel->update($id, ['is_read' => true]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}