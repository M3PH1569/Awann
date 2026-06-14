<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" href="<?= base_url('images/LogoIcon.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins';
            background-color: #ffffff;
        }

        .bg-custom-blue {
            background-color: #1e4b8f;
        }

        .text-custom-blue {
            color: #1e4b8f;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-[#F1F1F1] h-screen flex flex-col overflow-hidden">
    <?php $uri = service('uri'); ?>

    <nav class="fixed w-full bg-[#1C4D8D] text-white px-6 pt-1 pb-1 flex justify-between items-center shadow-md z-[49]">
        <img src="<?= base_url('images/awan.png') ?>" width="200px">
        <div class="flex items-center gap-6">
            <!-- Notification Bell -->
            <div x-data="notificationComponent()" x-init="init()" class="relative mt-1">
                <button @click="open = !open; if(open) fetchPendingReturns()" class="text-white hover:text-[#B3B3B3] transition relative flex items-center justify-center">
                    <i class="fa-solid fa-bell text-xl"></i>
                    <span x-show="count > 0" x-text="count" x-cloak class="absolute -top-1.5 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-md"></span>
                </button>

                <div x-show="open" x-cloak @click.outside="open = false" class="absolute right-0 mt-6 w-80 bg-white text-black rounded-lg shadow-2xl overflow-hidden z-50 border border-gray-200">
                    <div class="bg-[#1C4D8D] text-white px-4 py-3 font-bold text-sm flex justify-between items-center shadow-inner">
                        <span>Notifikasi Pengembalian</span>
                        <span x-show="count > 0" x-text="count + ' Baru'" class="bg-red-500 px-2 py-0.5 rounded-full text-[10px]"></span>
                    </div>
                    <div class="max-h-[330px] overflow-y-auto divide-y divide-gray-100">
                        <template x-if="requests.length === 0">
                            <div class="p-6 text-center text-gray-500 text-sm">
                                <i class="fa-regular fa-bell-slash text-2xl mb-2 text-gray-300"></i>
                                <p>Tidak ada request pengembalian.</p>
                            </div>
                        </template>
                        <template x-for="req in requests" :key="req.group_id">
                            <div @click="openReviewModal(req)" class="p-4 hover:bg-[#F9FBFF] cursor-pointer transition-colors border-l-4 border-transparent hover:border-[#1C4D8D]">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="font-bold text-sm text-[#1C4D8D]">
                                        <i class="fa-solid fa-user-circle mr-1 opacity-70"></i> <span x-text="req.nama_user || '-'"></span>
                                    </div>
                                    <span x-show="!req.is_read" class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm">NEW</span>
                                </div>
                                <div class="text-[10px] text-gray-500 font-medium" x-text="req.created_at"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Review Modal -->
                <div x-show="reviewOpen" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50">
                    <div @click.outside="closeReviewModal()" class="bg-white rounded-lg shadow-xl w-[90%] md:w-[500px] overflow-hidden flex flex-col">
                        <div class="flex justify-between items-center bg-[#1C4D8D] text-white px-4 py-3">
                            <h3 class="font-bold text-sm">Review Pengembalian</h3>
                            <button @click="closeReviewModal()" class="text-white hover:text-gray-300 transition">
                                <i class="fa-solid fa-xmark fa-lg"></i>
                            </button>
                        </div>
                        <div class="p-6" x-show="selectedReq">
                            <div class="mb-4">
                                <label class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">User</label>
                                <div class="font-semibold text-gray-800" x-text="selectedReq?.nama_user || '-'"></div>
                            </div>
                            <div class="mb-6">
                                <label class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Tanggal Request</label>
                                <div class="font-medium text-gray-700" x-text="selectedReq?.created_at"></div>
                            </div>

                            <table class="w-full text-left text-sm mb-6 border-collapse">
                                <thead>
                                    <tr>
                                        <th class="w-8 pb-2 text-center">
                                            <input type="checkbox" checked disabled class="w-3 h-3 accent-[#1C4D8D]">
                                        </th>
                                        <th class="text-[10px] text-gray-400 font-bold uppercase tracking-wider pb-2">No Registrasi</th>
                                        <th class="text-[10px] text-gray-400 font-bold uppercase tracking-wider pb-2 pl-4">Nama Perangkat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(dev, index) in selectedReq?.devices" :key="index">
                                        <tr :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                                            <td class="align-top py-2 px-2 border-b text-center">
                                                <input type="checkbox" class="w-3 h-3 cursor-pointer accent-[#1C4D8D]" :value="dev.request_id" x-model="checkedDevices">
                                            </td>
                                            <td class="align-top py-2 px-2 border-b">
                                                <div class="font-medium text-gray-700" x-text="dev.noreg"></div>
                                            </td>
                                            <td class="align-top py-2 px-2 border-b pl-4">
                                                <div class="font-medium text-gray-700 leading-tight" x-text="dev.nama_perangkat"></div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            
                            <div class="border-t border-gray-200 pt-4 flex justify-between items-center mt-2">
                                <button @click="refuseAll()" class="bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-600 transition font-semibold text-sm">
                                    <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                </button>
                                <div class="flex gap-2">
                                    <button @click="closeReviewModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Batal</button>
                                    <button @click="approveSelected()" class="bg-green-500 text-white px-6 py-2 rounded-md shadow hover:bg-green-600 transition font-semibold text-sm">
                                        <i class="fa-solid fa-check mr-1"></i> Setuju
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function notificationComponent() {
                        return {
                            open: false,
                            reviewOpen: false,
                            selectedReq: null,
                            checkedDevices: [],
                            requests: [],
                            count: 0,
                            init() {
                                this.fetchPendingReturns();
                                setInterval(() => this.fetchPendingReturns(), 15000);
                            },
                            openReviewModal(req) {
                                this.selectedReq = req;
                                this.checkedDevices = req.devices.map(d => d.request_id.toString());
                                this.reviewOpen = true;
                                this.open = false;

                                if (!req.is_read) {
                                    this.markAsRead(req);
                                }
                            },
                            markAsRead(req) {
                                req.is_read = true;
                                this.count = this.requests.filter(r => !r.is_read).length;

                                let params = new URLSearchParams();
                                req.devices.forEach(d => {
                                    params.append('request_ids[]', d.request_id);
                                });

                                fetch(`<?= base_url("dashboard/returns/mark-read") ?>`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: params
                                }).catch(err => console.error(err));
                            },
                            closeReviewModal() {
                                this.reviewOpen = false;
                                this.selectedReq = null;
                                this.checkedDevices = [];
                            },
                            approveSelected() {
                                if (this.selectedReq && this.selectedReq.devices) {
                                    const approvedIds = this.checkedDevices;
                                    const rejectedIds = this.selectedReq.devices
                                        .filter(d => !this.checkedDevices.includes(d.request_id.toString()))
                                        .map(d => d.request_id.toString());

                                    this.approveReq(approvedIds, rejectedIds);
                                }
                            },
                            refuseAll() {
                                if (this.selectedReq && this.selectedReq.devices) {
                                    const approvedIds = [];
                                    const rejectedIds = this.selectedReq.devices.map(d => d.request_id.toString());
                                    
                                    this.approveReq(approvedIds, rejectedIds);
                                }
                            },
                            fetchPendingReturns() {
                                fetch('<?= base_url("dashboard/returns") ?>')
                                    .then(res => res.json())
                                    .then(res => {
                                        if (res.success) {
                                            this.requests = res.data;
                                            this.count = res.data.filter(r => !r.is_read).length;
                                        }
                                    }).catch(err => console.error(err));
                            },
                            approveReq(approvedIds, rejectedIds) {
                                let params = new URLSearchParams();
                                approvedIds.forEach(id => {
                                    params.append('approved_ids[]', id);
                                });
                                rejectedIds.forEach(id => {
                                    params.append('rejected_ids[]', id);
                                });

                                fetch(`<?= base_url("dashboard/returns/approve") ?>`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: params
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.success) {
                                        if(typeof showToast === 'function') showToast(res.msg, 'success');
                                        this.closeReviewModal();
                                        this.fetchPendingReturns();
                                        setTimeout(() => window.location.reload(), 1500);
                                    } else {
                                        if(typeof showToast === 'function') showToast(res.msg, 'error');
                                        else alert(res.msg);
                                    }
                                });
                            }
                        }
                    }
                </script>
            </div>

            <div x-data="{open:false}" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-2 cursor-pointer transition group text-white hover:text-[#B3B3B3]">
                <i class="fa-regular fa-circle-user text-xl mb-1"></i>
                <span class="text-sm font-medium">
                    <?= session('admin')['username'] ?? 'admin' ?>
                </span>
                <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="{'rotate-180' : open}"></i>
            </button>

            <div x-show="open" x-cloak x-transition @click.outside="open = false"
                class="absolute right-0 mt-2 w-48 bg-white text-black rounded-md shadow-2xl text-sm">

                <button onclick="bukaModalPassword()" @click="open = false"
                    class="w-full rounded-t-md text-left px-4 py-3 text-[#1C4D8D] border-b border-gray-300 hover:bg-gray-200">
                    <i class="fa-solid fa-key mr-2" style="color: #1C4D8D;"></i>
                    Ganti Password
                </button>
                <!-- <hr class="mx-3 border-t-1 border-gray-300 my-1"/> -->
                <button onclick="openUserManage()" @click="open = false"
                    class="w-full text-left px-4 py-3 text-[#1C4D8D] border-b border-gray-300 hover:bg-gray-200">
                    <i class="fa-solid fa-user-gear mr-2" style="color: #1C4D8D;"></i>
                    User Manage
                </button>
                <?php 
                $adminSess = session()->get('admin');
                $isSuperAdmin = $adminSess && ((isset($adminSess['is_super']) && $adminSess['is_super'] == 1) || $adminSess['username'] === 'admin');
                if ($isSuperAdmin): 
                ?>
                <button onclick="openAdminManage()" @click="open = false"
                    class="w-full text-left px-4 py-3 text-[#1C4D8D] border-b border-gray-300 hover:bg-gray-200">
                    <i class="fa-solid fa-user-shield mr-2" style="color: #1C4D8D;"></i>
                    Admin Manage
                </button>
                <?php endif; ?>
                <a href="<?= base_url('logout') ?>"
                    class="rounded-b-md block px-4 py-3 text-[#1C4D8D] hover:bg-gray-200">
                    <i class="fa-solid fa-right-from-bracket mr-2" style="color: #1C4D8D;"></i>
                    Logout
                </a>
                <!-- <a href="<?= base_url('admin-manage') ?>" @click="open = false" class="block px-4 py-2 hover:bg-gray-100">
                    Admin Manage
                </a> -->
            </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 pt-24 pl-6 pr-6">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- PASSWORD MODAL -->
    <div id="overlayPassword"
        class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl w-[90%] md:w-[500px] overflow-hidden">
            <div class="flex justify-between items-center bg-[#1C4D8D] text-white px-4 py-3">
                <h3 class="font-bold">Ganti Password</h3>

                <button onclick="tutupModalPassword()" class="text-white hover:text-gray-400 transition">
                    <i class="fa-solid fa-xmark fa-xl"></i>
                </button>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 text-red-700 p-2 mb-4 text-sm rounded">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form id="gantiPassword" action="<?= base_url('update-password') ?>" method="post"
                class="p-4 flex flex-col justify-between">
                <?= csrf_field() ?>

                <div class="grid grid-cols-[180px,1fr] gap-x-6 gap-y-4 items-center text-left mb-5">

                    <label class="font-semibold text-[#1C4D8D] text-sm" for="current_password">Password Lama</label>
                    <div class="relative">
                        <input name="current_password" id="current_password" type="password"
                            class="w-full border rounded-sm p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1C4D8D]"
                            required>
                        <button type="button" onclick="showHide('current_password', 'eye_old')"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <i id="eye_old" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>

                    <label class="font-semibold text-[#1C4D8D] text-sm" for="new_password">Password Baru</label>
                    <div class="relative">
                        <input name="new_password" id="new_password" type="password"
                            class="w-full border rounded-sm p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1C4D8D]"
                            required>
                        <button type="button" onclick="showHide('new_password', 'eye_new')"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <i id="eye_new" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>

                    <label class="font-semibold text-[#1C4D8D] text-sm" for="confirm_password">Konfirmasi
                        Password</label>
                    <div class="relative">
                        <input name="confirm_password" id="confirm_password" type="password"
                            class="w-full border rounded-sm p-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#1C4D8D]"
                            required>
                        <button type="button" onclick="showHide('confirm_password', 'eye_conf')"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <i id="eye_conf" class="fa-solid fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-1">
                    <button type="submit"
                        class="bg-[#1C4D8D] text-white text-sm px-3 py-2 rounded-md font-semibold shadow hover:bg-[#3E679E] transition">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    <footer class="mt-auto text-xs text-[#1C4D8D] p-2 text-center">
        Unreleased &bull; PT. Aplikanusa Lintasarta &copy; <?= date('Y') ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <?= $this->renderSection('scripts') ?>
    <?php 
    $adminSess = session()->get('admin');
    $isSuperAdmin = $adminSess && ((isset($adminSess['is_super']) && $adminSess['is_super'] == 1) || $adminSess['username'] === 'admin');
    if ($isSuperAdmin): 
    ?>
    <?= view('components/adminmanage') ?>
    <?php endif; ?>

    <script>
        const overlay = document.getElementById('overlayPassword');

        function bukaModalPassword() {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            localStorage.setItem('showModal', 'true');
        }

        function tutupModalPassword() {
            document.getElementById('overlayPassword').classList.add('hidden');

            document.getElementById('gantiPassword').reset();

            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            localStorage.removeItem('showModal');
        }

        window.onclick = function (event) {
            if (event.target == overlay) {
                tutupModalPassword();
            }
        }
        window.addEventListener('load', function () {
            if (localStorage.getItem('showModal') === 'true') {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            }
        });
        function showHide(idInput, idIcon) {
            const inputan = document.getElementById(idInput);
            const ikon = document.getElementById(idIcon);

            if (inputan.type === "password") {
                inputan.type = "text";
                ikon.classList.remove('fa-eye-slash');
                ikon.classList.add('fa-eye');
            } else {
                inputan.type = "password";
                ikon.classList.remove('fa-eye');
                ikon.classList.add('fa-eye-slash');
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            <?php if (session()->getFlashdata('openModal') || session()->getFlashdata('show_modal')): ?>
                bukaModalPassword();
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '<?= esc(session()->getFlashdata('success')) ?>',
                    confirmButtonColor: '#1C4D8D'
                });
            <?php endif; ?>

            <?php if (session()->getFlashdata('error') && !session()->getFlashdata('openModal') && !session()->getFlashdata('show_modal')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: '<?= esc(session()->getFlashdata('error')) ?>',
                    confirmButtonColor: '#1C4D8D'
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>