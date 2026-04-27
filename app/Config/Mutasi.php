<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Mutasi extends BaseConfig
{
    public array $status = [
        'Dibawa',
        'Terpasang',
        'Kembali',
        'Pengiriman',
        'Terkirim',
    ];
}