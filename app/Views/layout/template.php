<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?= esc($title) ?> </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- tailwind -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
</head>
<style>
    
</style>
<body class="bg-primary font-inter">
    <!-- PARSIAL -->
    <?php if ($title === 'Dashboard Admin' || $title === 'Dashboard Info' || $title === 'Dashboard Pengaturan' || $title === 'Dashboard Manajemen Booth' || $title === 'Dashboard Booth'): ?>
        <?= $this->include('layout/sidebar2') ?> 
        <?= $this->include('layout/footer') ?> 
    <?php endif; ?>
    
    <?= $this->renderSection('content'); ?>
    <!-- dropdown bekerja -->
    <script src="<?= base_url('/assets/js/script.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>