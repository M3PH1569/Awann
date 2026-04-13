<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://cdn.tailwindcss.com"></script>

  <title>AWan - Asset Warehouse Management</title>

  <link rel="icon" href="<?= base_url('images/LogoLintas.png') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
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
  </style>
</head>

<body class="bg-[#F1F1F1] h-screen flex flex-col">
  <?php $uri = service('uri'); ?>

  <nav class="fixed w-full bg-[#1C4D8D] text-white px-6 flex justify-between items-center shadow-md">
    <img src="<?= base_url('images/awan.png') ?>" width="250px">

    <div class="flex gap-8 items-center">
      <a href="<?= base_url('/') ?>" class="flex flex-col items-center cursor-pointer transition group
        <?= $uri->getSegment(1) == '' ? 'text-[#7FB3D5] font-semibold border-b-2 border-[#7FB3D5]' : 'hover:text-[#7FB3D5]' ?>">
        <i class="fa-solid fa-table-list text-lg mb-1"></i>
        <span class="text-sm">Form</span>
      </a>

      <a href="<?= base_url('history') ?>" class="flex flex-col items-center cursor-pointer transition group
        <?= $uri->getSegment(1) == 'history' ? 'text-[#7FB3D5] font-semibold border-b-2 border-[#7FB3D5]' : 'hover:text-[#7FB3D5]' ?>">
        <i class="fa-solid fa-clock-rotate-left text-lg mb-1"></i>
        <span class="text-sm">History</span>
      </a>

      <a href="<?= base_url('login') ?>" class="flex flex-col items-center cursor-pointer transition group
        <?= $uri->getSegment(1) == 'login' ? 'text-[#7FB3D5] font-semibold border-b-2 border-[#7FB3D5]' : 'hover:text-[#7FB3D5]' ?>">
        <i class="fa-solid fa-arrow-right-to-bracket text-lg mb-1"></i>
        <span class="text-sm">Login</span>
      </a>
    </div>
  </nav>

  <main class="flex-1 pt-24 pl-4 pr-4">
    <?= $this->renderSection('content') ?>
  </main>

  <?= $this->renderSection('content') ?>

  <div id="overlayPassword" class="fixed inset-0 left-0 top-0 z-[9999] hidden bg-black/60 flex items-center justify-center p-4">
      <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl p-12 relative">
          <button onclick="tutupModalPassword()" class="absolute top-8 right-10 text-3xl font-light">&times;</button>
          <h2 class="text-3xl font-bold mb-12 text-left">Ganti Password</h2>

          <form action="<?= base_url('update-password') ?>" method="post" class="flex-flex-col gap-6">
            <div class="grid grid-cols-[180px,1fr] gap-x-6 gap-y-2 items-center text-left">
    
    <label class="font-semibold text-[#1C4D8D] text-sm" for="username">
        Username
    </label>
    <input name="username" id="username" type="text" required placeholder="Masukkan username" 
           class="border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#1C4D8D] bg-white shadow-sm placeholder-gray-400">

    <label class="font-semibold text-[#1C4D8D] text-sm" for="current_password">
        Password Lama
    </label>
    <input name="current_password" id="current_password" type="password" required placeholder="Masukkan password lama" 
           class="border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#1C4D8D] bg-white shadow-sm placeholder-gray-400">

    <label class="font-semibold text-[#1C4D8D] text-sm" for="new_password">
        Password Baru
    </label>
    <input name="new_password" id="new_password" type="password" required placeholder="Masukkan password baru" 
           class="border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#1C4D8D] bg-white shadow-sm placeholder-gray-400">

    <label class="font-semibold text-[#1C4D8D] text-sm" for="confirm_password">
        Konfirmasi Password
    </label>
    <input name="confirm_password" id="confirm_password" type="password" required placeholder="Konfirmasi password baru" 
           class="border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-1 focus:ring-[#1C4D8D] bg-white shadow-sm placeholder-gray-400">
  
          </div>
            <button class="bg-[#1C4D8D] w-full text-white p-3 rounded-lg font-bold shadow-md hover:bg-[#3E679E] transition mt-8" type="submit">
                Ganti Password
            </button>
            </div>
          </form>
          </div>
  <script>
      function bukaModalPassword() {
          const overlay = document.getElementById('overlayPassword');
          overlay.classList.remove('hidden');
          overlay.classList.add('flex');
      }

      function tutupModalPassword() {
          const overlay = document.getElementById('overlayPassword');
          overlay.classList.add('hidden');
          overlay.classList.remove('flex');
      }
  </script>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-500 text-white p-4 rounded-lg mb-4 text-center">
        <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-500 text-white p-4 rounded-lg mb-4 text-center">
        <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>


  <footer class="mt-auto text-xs text-[#1C4D8D] p-2 text-center">
    &copy; <?= date('Y') ?> PT. Aplikanusa Lintasarta
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
</body>

</html>