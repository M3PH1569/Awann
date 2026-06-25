<div id="adminManageModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-xl w-[90%] md:w-[560px] overflow-hidden">

        <div class="flex justify-between items-center bg-[#1C4D8D] text-white px-4 py-3">
            <h3 class="font-bold">Admin Manage</h3>
            <button onclick="closeAdminManage()" class="text-white hover:text-gray-400 transition">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
        </div>

        <div class="p-4 flex flex-col overflow-y-auto max-h-[75vh]">

            <!-- Add Admin Form -->
            <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-xs font-semibold text-[#1C4D8D] mb-2"><i class="fa-solid fa-user-plus mr-1"></i>Tambah Admin Baru</p>
                <div class="grid grid-cols-1 gap-2">
                    <input type="text" id="newAdminNama" placeholder="Nama Lengkap"
                        class="border border-gray-300 px-3 py-2 rounded-md text-xs focus:ring-1 focus:ring-[#1C4D8D] outline-none">
                    <input type="text" id="newAdminUsername" placeholder="Username"
                        class="border border-gray-300 px-3 py-2 rounded-md text-xs focus:ring-1 focus:ring-[#1C4D8D] outline-none">
                    <button onclick="saveNewAdmin()"
                        class="bg-[#1C4D8D] hover:bg-[#3E679E] text-white px-4 py-2 rounded-md text-xs font-semibold transition">
                        <i class="fa-solid fa-plus mr-1"></i> Simpan Admin
                    </button>
                </div>
            </div>

            <!-- Admin List -->
            <div class="mb-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400 text-xs"></i>
                    </div>
                    <input type="text" id="searchAdmin" onkeyup="filterAdmins()" placeholder="Cari Nama / Username..." class="w-full border border-gray-300 pl-8 pr-3 py-2 rounded-md text-xs focus:ring-1 focus:ring-[#1C4D8D] outline-none">
                </div>
            </div>
            <div class="overflow-y-auto flex-1">
                <table class="min-w-full text-sm text-left border border-gray-300">
                    <thead class="sticky top-0 z-10 bg-[#0F2854] text-white">
                        <tr>
                            <th class="px-4 py-3 text-center w-[70px] border border-gray-300">Action</th>
                            <th class="px-4 py-3 text-center w-[50px] border border-gray-300">No</th>
                            <th class="px-4 py-3 text-left border border-gray-300">Nama</th>
                            <th class="px-4 py-3 text-left border border-gray-300">Username</th>
                        </tr>
                    </thead>
                    <tbody id="adminManageBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.openAdminManage = function () {
        document.getElementById('adminManageModal').classList.remove('hidden');
        document.getElementById('adminManageModal').classList.add('flex');
        loadAdmins();
    }

    function closeAdminManage() {
        document.getElementById('adminManageModal').classList.add('hidden');
        document.getElementById('adminManageModal').classList.remove('flex');
        document.getElementById('newAdminNama').value = '';
        document.getElementById('newAdminUsername').value = '';
        document.getElementById('searchAdmin').value = '';
    }

    let allAdmins = [];

    function loadAdmins() {
        fetch('<?= base_url('dashboard/adminList') ?>')
            .then(res => res.json())
            .then(admins => {
                allAdmins = admins;
                renderAdmins(admins);
            });
    }

    function filterAdmins() {
        const term = document.getElementById('searchAdmin').value.toLowerCase();
        const filtered = allAdmins.filter(a => 
            a.nama.toLowerCase().includes(term) || a.username.toLowerCase().includes(term)
        );
        renderAdmins(filtered);
    }

    function renderAdmins(admins) {
        const tbody = document.getElementById('adminManageBody');
        const currentId = <?= session('admin')['id'] ?? 0 ?>;
        tbody.innerHTML = '';

        if (!admins.length) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-xs text-gray-500">Tidak ada admin</td></tr>`;
            return;
        }

        let no = 1;
        admins.forEach(a => {
            const isSelf = a.id == currentId;
            tbody.innerHTML += `
                <tr class="text-[#656565] odd:bg-white even:bg-[#EFEFEF] hover:text-black">
                    <td class="px-4 py-3 text-center border border-gray-300">
                        ${isSelf
                            ? `<span class="text-xs text-gray-400 italic">Anda</span>`
                            : `<div class="flex items-center justify-center gap-2">
                                <button type="button" onclick="editAdmin(${a.id}, '${a.nama.replace(/'/g, "\\'")}', '${a.username.replace(/'/g, "\\'")}')" class="text-blue-500 hover:text-blue-400 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button type="button" onclick="resetAdminPassword(${a.id}, '${a.username.replace(/'/g, "\\'")}')" class="text-yellow-500 hover:text-yellow-400 transition" title="Reset Password">
                                    <i class="fa-solid fa-key text-xs"></i>
                                </button>
                                <button type="button" onclick="deleteAdmin(${a.id})" class="text-red-500 hover:text-red-400 transition" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                               </div>`
                        }
                    </td>
                    <td class="px-4 py-3 text-center text-xs border border-gray-300">${no++}</td>
                    <td class="px-4 py-3 text-left text-xs border border-gray-300">${a.nama}</td>
                    <td class="px-4 py-3 text-left text-xs border border-gray-300">${a.username}</td>
                </tr>`;
        });
    }

    function saveNewAdmin() {
        const nama     = document.getElementById('newAdminNama').value.trim();
        const username = document.getElementById('newAdminUsername').value.trim();

        if (!nama || !username) {
            showToast('Semua field wajib diisi', 'warning');
            return;
        }

        const csrfTokenElement = document.querySelector('input[name="csrf_test_name"]');
        const csrfToken = csrfTokenElement ? csrfTokenElement.value : '<?= csrf_hash() ?>';

        fetch('<?= base_url('dashboard/addAdmin') ?>', {
            method: 'POST',
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams({ nama, username, csrf_test_name: csrfToken })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                showToast('Admin berhasil ditambahkan', 'success');
                document.getElementById('newAdminNama').value = '';
                document.getElementById('newAdminUsername').value = '';
                loadAdmins();
            } else {
                showToast(res.msg ?? 'Gagal menambahkan admin', 'error');
            }
        });
    }

    function resetAdminPassword(id, username) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Yakin ingin mereset password admin <b>${username}</b> menjadi kosong?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const csrfTokenElement = document.querySelector('input[name="csrf_test_name"]');
                const csrfToken = csrfTokenElement ? csrfTokenElement.value : '<?= csrf_hash() ?>';

                fetch('<?= base_url('dashboard/resetAdminPassword') ?>/' + id, {
                    method: 'POST',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        showToast('Password admin berhasil direset', 'success');
                    } else {
                        showToast(res.msg ?? 'Gagal mereset password', 'error');
                    }
                });
            }
        });
    }

    function deleteAdmin(id) {
        Swal.fire({
            title: 'Hapus admin ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                const csrfTokenElement = document.querySelector('input[name="csrf_test_name"]');
                const csrfToken = csrfTokenElement ? csrfTokenElement.value : '<?= csrf_hash() ?>';

                fetch('<?= base_url('dashboard/deleteAdmin') ?>/' + id, {
                    method: 'POST',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        showToast('Admin berhasil dihapus', 'success');
                        loadAdmins();
                    } else {
                        showToast(res.msg ?? 'Gagal menghapus admin', 'error');
                    }
                });
            }
        });
    }

    function editAdmin(id, oldNama, oldUsername) {
        Swal.fire({
            title: 'Edit Admin',
            html: `
                <input id="swal-nama" class="swal2-input" placeholder="Nama" value="${oldNama}">
                <input id="swal-username" class="swal2-input" placeholder="Username" value="${oldUsername}">
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                const nama = document.getElementById('swal-nama').value.trim();
                const username = document.getElementById('swal-username').value.trim();
                if (!nama || !username) {
                    Swal.showValidationMessage('Semua field wajib diisi');
                }
                return { nama, username };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfTokenElement = document.querySelector('input[name="csrf_test_name"]');
                const csrfToken = csrfTokenElement ? csrfTokenElement.value : '<?= csrf_hash() ?>';

                fetch('<?= base_url('dashboard/updateAdmin') ?>/' + id, {
                    method: 'POST',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: new URLSearchParams({
                        ...result.value,
                        csrf_test_name: csrfToken
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        showToast('Admin berhasil diupdate', 'success');
                        loadAdmins();
                    } else {
                        showToast(res.msg ?? 'Gagal update admin', 'error');
                    }
                });
            }
        });
    }

    function toggleAdminPwd() {
        const input = document.getElementById('newAdminPassword');
        const icon  = document.getElementById('adminPwdEye');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    }
</script>
