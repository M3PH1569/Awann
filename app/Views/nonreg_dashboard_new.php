<?= $this->extend('layouts/buatdashboard') ?>

<?= $this->section('content') ?>

<div id="toast" class="fixed top-20 right-5 z-50 hidden transform transition-all duration-300 translate-x-full">
  <div id="toastBox" class="flex items-center gap-2 px-4 py-3 rounded-lg shadow-lg text-white text-sm">
    <i id="toastIcon" class="fa-solid"></i>
    <span id="toastMsg"></span>
  </div>
</div>
<div class="max-w-[1450px] mx-auto w-full flex-1 flex flex-col">
  <div class="flex justify-between items-center w-full">
    <h2 class="text-base font-semibold mb-3">
      Selamat Datang, <?= session('admin')['nama'] ?? '' ?>!
    </h2>
  </div>

  <div class="flex gap-4 mb-4 border-b border-gray-300">
    <a href="<?= base_url('dashboard') ?>" class="font-semibold text-sm border-b-2 border-[#1C4D8D] text-[#1C4D8D] pb-2 px-1">Registrasi</a>
    <a href="<?= base_url('dashboard/nonreg') ?>" class="font-semibold text-sm text-gray-500 hover:text-[#1C4D8D] pb-2 px-1 transition-colors">Non-Registrasi</a>
  </div>

  <form method="get" class="bg-white p-2 rounded-md shadow mb-4 flex flex-wrap gap-3 items-center sticky top-[70px] z-[20]">
    <div class="relative flex items-center transition-all duration-500 ease-in-out" id="searchContainer" style="width: 250px;">
      <input type="text" id="searchInput" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Search Kode / Nama..."
        class="border text-xs rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-[#1C4D8D] pr-8 transition-all duration-500 ease-in-out">
    </div>

    <a href="/dashboard/nonreg" class="bg-[#1C4D8D] px-4 py-2 text-xs rounded-lg hover:bg-[#7AAACE] transition text-white">
      Reset Filter
    </a>
  </form>

  <div class="flex-1 bg-white rounded-md shadow flex flex-col overflow-hidden">
    <div class="flex-1 overflow-auto max-h-[calc(100vh-280px)]">
      <?php
      $currentSort = $_GET['sort_by'] ?? '';
      $currentDir = $_GET['sort_dir'] ?? '';
      function sortIcon($col, $currentSort, $currentDir)
      {
        if ($currentSort === $col) {
          return $currentDir === 'desc'
            ? '<i class="fa-solid fa-sort-down ml-1 text-[10px] opacity-100"></i>'
            : '<i class="fa-solid fa-sort-up ml-1 text-[10px] opacity-100"></i>';
        }
        return '<i class="fa-solid fa-sort ml-1 text-[10px] opacity-50"></i>';
      }
      ?>
      <table class="min-w-full text-xs text-left border border-gray-300 text-nowrap">
        <thead class="sticky top-0 z-10 bg-[#0F2854] text-white">
          <tr>
            <th class="px-4 py-3 text-xs text-center border border-gray-300 w-16">No</th>
            <th class="px-4 py-3 text-xs text-center border border-gray-300 w-24">Action</th>
            <th
              class="px-4 py-3 text-xs text-left border border-gray-300 cursor-pointer select-none hover:bg-[#1a3d6e] transition"
              onclick="sortTable('kode_spec')">Kode Spec <?= sortIcon('kode_spec', $currentSort, $currentDir) ?></th>
            <th
              class="px-4 py-3 text-xs text-left border border-gray-300 cursor-pointer select-none hover:bg-[#1a3d6e] transition"
              onclick="sortTable('nama_material')">Nama Material <?= sortIcon('nama_material', $currentSort, $currentDir) ?></th>
            <th
              class="px-4 py-3 text-xs text-center border border-gray-300 cursor-pointer select-none hover:bg-[#1a3d6e] transition"
              onclick="sortTable('quantity')">Sisa Stock <?= sortIcon('quantity', $currentSort, $currentDir) ?></th>
            <th
              class="px-4 py-3 text-xs text-center border border-gray-300 cursor-pointer select-none hover:bg-[#1a3d6e] transition"
              onclick="sortTable('updated_at')">Last Updated <?= sortIcon('updated_at', $currentSort, $currentDir) ?></th>
          </tr>
        </thead>

        <tbody class="divide-y">
          <?php $no = ($currentPage - 1) * $limit + 1;
          foreach ($perangkat as $p): ?>

            <tr id="row-<?= $p['id'] ?>"
              class="text-[#656565] odd:bg-white even:bg-[#EFEFEF] hover:text-black transition">
              
              <td class="px-4 py-3 text-center text-xs border border-gray-300"><?= $no++ ?></td>
              
              <td class="px-4 py-3 text-center text-xs text-blue-700 border border-gray-300">
                <button type="button" onclick="openNonRegHistory(<?= $p['id'] ?>, '<?= esc(addslashes($p['nama_material'])) ?>')" class="hover:text-blue-400 mr-1 transition" title="View History">
                  <i class="fa-solid fa-clock-rotate-left"></i> History
                </button>
              </td>

              <td class="px-4 py-3 text-left text-xs border border-gray-300 font-semibold"><?= esc($p['kode_spec']) ?></td>
              
              <td class="px-4 py-3 text-left text-xs border border-gray-300 break-words whitespace-normal min-w-[250px]">
                <?= esc($p['nama_material']) ?>
              </td>
              
              <td class="px-4 py-3 text-center text-xs border border-gray-300">
                <span class="px-2 py-1 rounded text-xs <?= $p['quantity'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> font-bold">
                  <?= esc($p['quantity']) ?>
                </span>
              </td>
              
              <td class="px-4 py-3 text-center text-xs border border-gray-300">
                <?= $p['updated_at'] ? date('d M Y H:i', strtotime($p['updated_at'])) : '-' ?>
              </td>

            </tr>

          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- History Modal -->
    <div id="historyModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-xl w-[95%] md:w-[850px] overflow-hidden flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center bg-[#1C4D8D] text-white px-4 py-3">
          <h3 class="font-bold text-sm">History: <span id="historyItemName"></span></h3>
          <button onclick="closeHistory()" class="text-white hover:text-gray-300 transition">
            <i class="fa-solid fa-xmark fa-lg"></i>
          </button>
        </div>
        <div class="p-4 flex-1 overflow-y-auto bg-[#F9FBFF]">
          
          <!-- Search History -->
          <div class="mb-3">
            <input type="text" id="searchHistoryInput" placeholder="Cari keterangan, user, atau status..."
              class="border text-xs rounded-md p-2 w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-[#1C4D8D]">
          </div>

          <div id="historyLoading" class="text-center py-8 hidden">
            <i class="fa-solid fa-spinner fa-spin text-3xl text-[#1C4D8D]"></i>
            <p class="text-sm mt-2 text-gray-500">Memuat history...</p>
          </div>
          
          <table id="historyTable" class="w-full text-left text-xs border-collapse bg-white shadow-sm rounded-md overflow-hidden border border-gray-200">
            <thead class="bg-gray-100 border-b border-gray-200">
              <tr>
                <th class="p-2 font-semibold text-gray-700 w-12 text-center">No</th>
                <th class="p-2 font-semibold text-gray-700">Tanggal</th>
                <th class="p-2 font-semibold text-gray-700">User</th>
                <th class="p-2 font-semibold text-gray-700">Keterangan</th>
                <th class="p-2 font-semibold text-gray-700 text-center">Mutasi</th>
                <th class="p-2 font-semibold text-gray-700 text-center">Status</th>
              </tr>
            </thead>
            <tbody id="historyBody" class="divide-y divide-gray-100">
              <!-- Content injected by JS -->
            </tbody>
          </table>
          
          <!-- History Pagination -->
          <div id="historyPagination" class="mt-4 flex justify-center gap-1 hidden">
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="py-1 mt-2">
    <div class="flex justify-center items-center gap-1 w-full">

      <?php $query = $_GET; ?>

      <!-- Prev -->
      <?php if ($currentPage > 1): ?>
        <?php $query['page'] = $currentPage - 1; ?>
        <a href="?<?= http_build_query($query) ?>" class="px-3 py-1 text-xs bg-gray-200 rounded">
          &laquo;
        </a>
      <?php endif; ?>

      <?php
      $start = max(1, $currentPage - 2);
      $end = min($totalPage, $currentPage + 2);
      ?>

      <!-- First page + dots -->
      <?php if ($start > 1): ?>
        <?php $query['page'] = 1; ?>
        <a href="?<?= http_build_query($query) ?>" class="px-3 py-1 text-xs bg-gray-200 rounded">1</a>
        <?php if ($start > 2): ?>
          <span class="px-2">...</span>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Middle pages -->
      <?php for ($i = $start; $i <= $end; $i++): ?>
        <?php $query['page'] = $i; ?>
        <a href="?<?= http_build_query($query) ?>" class="px-3 py-1 text-xs rounded 
          <?= $i == $currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <!-- Last page + dots -->
      <?php if ($end < $totalPage): ?>
        <?php if ($end < $totalPage - 1): ?>
          <span class="px-2">...</span>
        <?php endif; ?>
        <?php $query['page'] = $totalPage; ?>
        <a href="?<?= http_build_query($query) ?>" class="px-3 py-1 text-xs bg-gray-200 rounded">
          <?= $totalPage ?>
        </a>
      <?php endif; ?>

      <!-- Next -->
      <?php if ($currentPage < $totalPage): ?>
        <?php $query['page'] = $currentPage + 1; ?>
        <a href="?<?= http_build_query($query) ?>" class="px-3 py-1 text-xs bg-gray-200 rounded">
          &raquo;
        </a>
      <?php endif; ?>

    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // SERVER-SIDE TABLE SORTING
  function sortTable(column) {
    const params = new URLSearchParams(window.location.search);
    const currentSort = params.get('sort_by');
    const currentDir = params.get('sort_dir');

    let newDir = 'asc';
    if (currentSort === column) {
      newDir = currentDir === 'asc' ? 'desc' : 'asc';
    }

    params.set('sort_by', column);
    params.set('sort_dir', newDir);
    params.set('page', '1');

    window.location.search = params.toString();
  }
</script>
<script>
  function showToast(message, type = "error") {
    const toast = document.getElementById("toast");
    const box = document.getElementById("toastBox");
    const msg = document.getElementById("toastMsg");
    const icon = document.getElementById("toastIcon");

    if (!toast || !box || !msg || !icon) return;

    msg.innerText = message;
    box.className = "flex items-center gap-2 px-4 py-3 rounded-lg shadow-lg text-white text-sm";

    if (type === "error") {
      box.classList.add("bg-red-500");
      icon.className = "fa-solid fa-circle-xmark";
    } else if (type === "success") {
      box.classList.add("bg-green-500");
      icon.className = "fa-solid fa-circle-check";
    } else {
      box.classList.add("bg-yellow-500");
      icon.className = "fa-solid fa-triangle-exclamation";
    }

    toast.classList.remove("hidden", "translate-x-full");
    toast.classList.add("translate-x-0");

    setTimeout(() => {
      toast.classList.remove("translate-x-0");
      toast.classList.add("translate-x-full");
      setTimeout(() => { toast.classList.add("hidden"); }, 300);
    }, 3000);
  }


