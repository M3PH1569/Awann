<?= $this->extend('layouts/buatdashboard') ?>

<?= $this->section('content') ?>

<h2 class="text-xl font-semibold mb-3">
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
            <button onclick="openEdit(<?= $p['id'] ?>)" 
              class="text-blue-600">
              <i class="fas fa-edit"></i>
            </button>
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

  <div id="editModal" class="fixed inset-0 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white border border-gray-200 rounded-md shadow-md w-full max-w-md p-6 relative">
      <button onclick="closeModal()" class="absolute right-3 top-3 text-black text-lg font-bold focus:outline-none">
        <i class="fas fa-times"></i>
      </button>

      <h2 class="text-base text-black font-semibold mb-4">Edit Perangkat</h2>
      <form id="editForm">
        <input type="hidden" name="id" id="edit_id">

        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">No Registrasi</label>
          <input type="text" id="edit_noreg" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2 bg-gray-100" disabled>
        </div>
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">Nama Perangkat</label>
          <input type="text" id="edit_np" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2 bg-gray-100" disabled>
        </div>
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">Serial Number</label>
          <input type="text" id="edit_sn" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2 bg-gray-100" disabled>
        </div>

        <hr class="my-4">

        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">Nama User</label>
          <select id="edit_user" name="id_users" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2">
            <option value="">Pilih User</option>
            <?php foreach($users as $u): ?>
              <option value="<?= $u['id'] ?>">
                <?= $u['nama'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">Status</label>
          <select id="edit_status" name="status_mutasi" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2">
            <option value="">Pilih Status</option>
            <?php foreach($statuses as $s): ?>
              <option value="<?= $s ?>">
                <?= $s ?>
              </option>
            <?php endforeach;?>
          </select>
        </div>

        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700">Keterangan</label>
          <textarea x.model="form.reason" id="edit_keterangan" name="keterangan" class="mt-1 block w-full border border-gray-300 shadow-sm rounded-md p-2"></textarea>
        </div>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded">Batal</button>
          <button type="submit" class="px-4 py-2 bg-[#0066CC] text-white rounded">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?=  $this->section('scripts') ?>
<script>
window.openEdit = function(id)
{
  fetch("<?=  base_url('dashboard/edit') ?>/"+id)
  .then(res=>res.json())
  .then(data=>{
    console.log(data);

    document.getElementById("edit_id").value=data.id;
    document.getElementById("edit_noreg").value=data.noreg;
    document.getElementById("edit_np").value=data.nama;
    document.getElementById("edit_sn").value=data.serial_number;

    document.getElementById("edit_user").value=data.id_users ?? "";
    document.getElementById("edit_status").value=data.status ?? "";
    document.getElementById("edit_keterangan").value=data.keterangan ?? "";

    document.getElementById("editModal").classList.remove("hidden");
    document.getElementById("editModal").classList.add("flex");
  });
}

window.closeModal = function()
{
  document.getElementById("editModal").classList.add("hidden");
  document.getElementById("editModal").classList.remove("flex");
}

document.getElementById("editForm").addEventListener("submit", function(e){e.preventDefault();
  let formData = new FormData(this);

  fetch("<?= base_url('dashboard/update') ?>", {
    method: "POST",
    body: formData
  })
  .then(res=>res.json())
  .then(()=> {
    location.reload();
  });
});
</script>
<?=  $this->endSection() ?>