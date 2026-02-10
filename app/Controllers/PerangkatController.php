<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\PerangkatModel;

class PerangkatController extends BaseController
{
    protected $perangkatModel;

    public function __construct()
    {
        $this->perangkatModel = new PerangkatModel();
    }

    public function index()
    {
        $data['perangkat']=$this->perangkatModel->findAll();
        return view('dashboard/perangkat', $data);
    }

    public function store()
    {
        $this->perangkatModel->insert([
            'noreg'=>$this->request->getPost('noreg'),
            'nama_perangkat'=>$this->request->getPost('nama_perangkat'),
            'serial_number'=>$this->request->getPost('serial_number'),
            'status'=>'Tersedia'
        ]);

        return redirect()->to('/perangkat');
    }
}
