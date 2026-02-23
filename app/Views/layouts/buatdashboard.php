<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="bg-[#EDEDED] min-h-screen flex items-start p-6 font-sans">

    <!-- Sidebar -->
    <aside class="bg-[#0066CC] text-white w-52 h-screen fixed left-0 top-0 p-4 flex flex-col shadow-lg">
        <a href="#" class="text-xl font-bold mb-6 hover:text-white">Asset & Warehouse Management</a>
        <nav class="flex flex-col space-y-3 text-sm font-medium">
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-100 transition bg-white text-[#0066CC] shadow">
                <i class="fas fa-home text-base"></i> <span>Dashboard</span>
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 ml-52 mt-8 p-6">
        <?= $this->renderSection('content') ?>

        <!-- Header -->
        <header class="bg-[#0066CC] text-white fixed left-52 top-0 right-0 px-6 py-4 flex items-center justify-between shadow-md z-40">
            <div class="font-semibold text-xl">Dashboard</div>
            <div class="flex space-x-6 text-white text-lg items-center">
                <div class="relative">
                    <button id="notifButton" class="relative focus:outline-none">
                        <i class="far fa-bell fa-lg cursor-pointer hover:scale-110 transition-transform duration-200"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs px-1.5">3</span>
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white text-black rounded-lg shadow-xl z-50">
                        <div class="p-4">
                            <h4 class="font-bold text-sm mb-2">Notifikasi Terbaru</h4>
                            <p class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <button id="profileButton" class="hover:scale-110 transition-transform duration-200">
                        <i class="far fa-user-circle fa-lg"></i>
                    </button>
                    <div id="profileMenu" class="hidden absolute right-0 mt-5 w-40 bg-[#0066CC] text-white rounded-md shadow-lg z-50">
                        <ul class="p-3 space-y-2 font-semibold text-sm">
                            <li><a href="#" class="block hover:underline">Dashboard</a></li>
                            <li>
                                <form method="POST" action="/logout">
                                    <?= csrf_field() ?><button type="submit" class="w-full text-left hover:underline">Log Out</button></form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </main>

    <?=  $this->renderSection('scripts') ?>
    
</body>

<script>    
    // Profile & notif dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const profileBtn = document.getElementById('profileButton');
        const profileMenu = document.getElementById('profileMenu');
        profileBtn?.addEventListener('click', e => {
            e.stopPropagation();
            profileMenu?.classList.toggle('hidden');
        });
        window.addEventListener('click', () => profileMenu?.classList.add('hidden'));

        const notifBtn = document.getElementById('notifButton');
        const notifDropdown = document.getElementById('notifDropdown');
        notifBtn?.addEventListener('click', e => {
            e.stopPropagation();
            notifDropdown?.classList.toggle('hidden');
        });
        window.addEventListener('click', () => notifDropdown?.classList.add('hidden'));
    });
</script>