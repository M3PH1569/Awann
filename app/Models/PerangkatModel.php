<?php

namespace App\Models;

use CodeIgniter\Model;

class PerangkatModel extends Model
{
    protected $table            = 'perangkat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'noreg', 'serial_number', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDataDash()
    {
        return $this->db->query("
        SELECT
        p.*,
        m.status as status_mutasi,
        m.keterangan as keterangan_mutasi,
        m.created_at as mutasi_created,
        m.updated_at as mutasi_updated,
        u.nama as nama_user
        FROM perangkat p
        LEFT JOIN mutasi m ON m.id = (
        SELECT id FROM mutasi
        WHERE id_perangkat = p.id
        ORDER BY created_at DESC
        LIMIT 1
        )
        LEFT JOIN users u ON u.id = m.id_users
        ORDER BY p.id ASC
        ")->getResultArray();
    }
}
