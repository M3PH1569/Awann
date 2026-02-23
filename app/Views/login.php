<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl p-8 max-w-3xl w-full mx-auto"
    style="box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    <form action="<?= base_url('/login') ?>" method="post" class="space-y-4">

        <div>
            <label class="block font-semibold text-black text-sm mb-1" for="username">
                Username
            </label>
            <input name="username" class="w-full rounded-lg border border-gray-500 py-2 px-3 mb-4 text-black placeholder-gray-400" id="username" placeholder="Masukkan username" required type="text" />
        </div>

        <div>
            <label class="block font-semibold text-black text-sm mb-1" for="password">
                Password
            </label>
            <input name="password" class="w-full rounded-lg border border-gray-500 py-2 px-3 mb-4 text-black placeholder-gray-400" id="password" placeholder="Masukkan password" required type="password" />
        </div>

        <button class="w-full rounded-lg bg-[#0066CC] font-semibold text-white py-2 mb-3 hover:bg-blue-200 transsition-colors" type="submit">
            Login
        </button>
    </form>
</div>

<?= $this->endSection() ?>