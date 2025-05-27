<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    
</head>
<body>
    <!-- PARSIAL -->
    <?php if ($title === 'Halaman Login Admin') : ?>
        <?= $this->include('user/login') ?> 
    <?php endif; ?>
    <?= $this->include('layout/sidebar') ?> 

    <?= $this->renderSection('content'); ?>
</body>
</html>