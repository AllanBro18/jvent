<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('alert')) :
    $type = session()->getFlashdata('alert_type') ?? 'info';

    $colorClasses = [
        'success' => 'bg-green-500 text-white',
        'error'   => 'bg-red-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'info'    => 'bg-blue-500 text-white',
    ];

    $color = $colorClasses[$type] ?? $colorClasses['info'];
?>
<div 
    id="alertBox"
    class="transition-all transform scale-95 opacity-0 duration-300 mb-4 p-4 rounded-md shadow-md <?= $color ?>"
>
    <div class="flex justify-between items-center">
            <span><?= session()->getFlashdata('alert') ?></span>
            <button onclick="document.getElementById('alertBox').remove()" class="ml-4 text-lg font-bold leading-none">&times;</button>
    </div>
</div>

<script>
    // Delay to let DOM render, then apply animation
    window.addEventListener('DOMContentLoaded', () => {
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
        setTimeout(() => {
            alertBox.classList.remove('scale-95', 'opacity-0');
            alertBox.classList.add('scale-100', 'opacity-100');
        }, 100);
        }
    });

    setTimeout(() => alertBox?.remove(), 4000);
</script>
<?php endif; ?>

<?= $this->endSection() ?>