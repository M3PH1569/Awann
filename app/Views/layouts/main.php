<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title><?= $title ?? 'Asset Management' ?></title>
</head>

<body class="bg-gradient-to-b from-[#ffffff] via-white/80 to-[#0749ff] min-h-screen flex flex-col px-4 py-6">
  <header class="bg-[#0749ff] text-[#ffffff] fixed left-0 top-0 right-0 h-20 px-6 py-4 text-center mb-6">
    <h1 class="text-3xl font-bold">MuBa</h1>
  </header>

  <main class="flex justify-center pt-28">
    <?= $this->renderSection('content') ?>
  </main>

  <footer class="mt-auto text-xs text-white text-center">
    &copy; <?= date('Y') ?> anak baik
  </footer>
</body>

</html>