<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    
</head>
<body>
    <!-- PARSIAL -->
    

    <?= $this->renderSection('content'); ?>

    <script src="/js/script.js"></script>
</body>
</html>