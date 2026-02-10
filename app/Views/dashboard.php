<?= $this->extend('layouts/buatdashboard') ?>

<?= $this->section('content') ?>

<h2 class="text-xl font-semibold mb-4">
  Selamat Datang, <?=  session('admin')['nama'] ?? 'Admin' ?>!
</h2>

<div class="bg-white rounded-xl shadow overflow-hidden">
  <div class="overflow-x-auto">

    <table class="min-w-full text-sm text-left">
      <thead class="bg-[#000033] text-white">
        <tr>
          <th class="px-4 py-3">Action</th>
          <th class="px-4 py-3">No</th>
          <th class="px-4 py-3">No Registrasi</th>
          <th class="px-4 py-3">Nama Perangkat</th>
          <th class="px-4 py-3">Serial Number</th>
          <th class="px-4 py-3">User</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Keterangan</th>
          <th class="px-4 py-3">Created</th>
          <th class="px-4 py-3">Updated</th>
        </tr>
      </thead>
      
      <tbody class="divide-y">
        <?php $no = 1; foreach($perangkat as $p): ?>
        
        <tr class="hover:bg-gray-50">
          <td class="px-4 py-3">
            <a href="dashboard/edit/<?= $p['id'] ?>" 
              class="text-blue-600">
              <i class="fas fa-edit"></i>
            </a>
          </td>

          <td class="px-4 py-3"><?= $no++ ?></td>
          <td class="px-4 py-3"><?= esc($p['noreg']) ?></td>
          <td class="px-4 py-3"><?= esc($p['nama']) ?></td>
          <td class="px-4 py-3"><?= esc($p['serial_number']) ?></td>
          <td class="px-4 py-3"><?= $p['nama_user'] ?? '-' ?></td>

          <td class="px-4 py-3">
            <span class="px-2 py-1 rounded text-xs
              <?= $p['status_mutasi']=='Dibawa' ? 'bg-yellow-200 text-yellow-800' : '' ?>
              <?= $p['status_mutasi']=='Terpasang' ? 'bg-blue-200 text-blue-800' : '' ?>
              <?= $p['status_mutasi']=='Kembali' ? 'bg-green-200 text-green-800' : '' ?>
              ">
              <?=  $p['status_mutasi'] ?? '-' ?>
            </span>
          </td>

          <td class="px-4 py-3"><?= esc($p['keterangan_mutasi']) ?: '-' ?></td>
          <td class="px-4 py-3"><?= $p['created_at'] ?></td>
          <td class="px-4 py-3"><?= $p['mutasi_updated'] ?></td>
        </tr>

        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>