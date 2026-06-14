<?= $this->extend('layouts/buatdashboard') ?>

<?= $this->section('content') ?>

    <h2 class="text-xl font-semibold mb-4">Mutasi Barang</h2>
    <?php if (empty($registeredEvents)): ?>
        <p class="text-gray-500">Belum ada DATANYA</p>
    <?php else: ?>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left-border border-gray-200 rounded-lg overflow-hidden"></table>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($registeredEvents as $event): ?>
                <?php
                $image = $event['photo'] ?? 'images/default-event.jpg';
                $review = $eventReviews[$event['id']] ?? null;
                ?>
                <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                    <img src="<?= $image ?>" alt="<?= $event['title'] ?>" class="rounded mb-3 h-40 w-full object-cover">
                    <h3 class="font-semibold text-lg"><?= $event['title'] ?></h3>
                    <p class="text-sm text-gray-600"><?= $event['category'] ?></p>
                    <p class="text-sm"><?= $event['start_date'] ?> - <?= $event['end_date'] ?></p>
                    <p class="text-sm"><?= $event['location'] ?></p>
                    <button onclick="togglePresensi('presensi-<?= $event['id'] ?>', true)" class="mt-2 bg-[#4A7CFD] text-white py-1 px-2 rounded">Presensi</button>
                    <button onclick="openUlasan('ulasan-<?= $event['id'] ?>')" class="mt-1 bg-gray-200 text-gray-800 py-1 px-2 rounded">Lihat Ulasan</button>

                    <!-- Presensi Overlay -->
                    <div id="presensi-<?= $event['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white p-6 rounded-lg w-96">
                            <h4 class="font-bold mb-4">Presensi <?= $event['title'] ?></h4>
                            <button onclick="togglePresensi('presensi-<?= $event['id'] ?>', false)" class="text-sm text-red-500 hover:underline">Tutup</button>
                        </div>
                    </div>

                    <!-- Ulasan Overlay -->
                    <div id="ulasan-<?= $event['id'] ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white p-6 rounded-lg w-96">
                            <h4 class="font-bold mb-4">Ulasan <?= $event['title'] ?></h4>
                            <?php if ($review): ?>
                                <p><?= $review['message'] ?></p>
                            <?php else: ?>
                                <p class="text-gray-500">Belum ada ulasan</p>
                            <?php endif; ?>
                            <button onclick="closeUlasan('ulasan-<?= $event['id'] ?>')" class="text-sm text-red-500 hover:underline">Tutup</button>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
</main>
</body>

<script>
    function togglePresensi(id, show) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = show ? 'flex' : 'none';
        el.classList.toggle('hidden', !show);
    }

    function openUlasan(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = 'flex';
            el.classList.remove('hidden');
        }
    }

    function closeUlasan(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = 'none';
            el.classList.add('hidden');
        }
    }

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

<?= $this->endSection() ?>