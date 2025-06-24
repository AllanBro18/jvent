<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<div class="p-4 sm:ml-64">
    <div class="flex flex-col md:flex-row text-white min-h-screen">
        <!-- Main Content -->
        <main class="flex-1 p-5 sm:p-8">
            <!-- Greeting Admin -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                <div class="p-5">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> Hello <?= esc($username_admin) ?>, Selamat Datang! </h5>
                    <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"></p>
                    <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"></p>
                </div>
            </div>
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5 my-5">
                <!-- Total Event -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <div class="p-5">
                        <p class="mb-1 text-sm font-light text-gray-700 dark:text-gray-400">Jumlah Event</p>
                        <p class="mb-1 text-lg text-gray-700 dark:text-white"> <?= count($events) ?> </p>
                    </div>
                </div>
                
                <!-- Total Booth -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <div class="p-5">
                        <p class="mb-1 text-sm font-light text-gray-700 dark:text-gray-400">Jumlah Booth</p>
                        <p class="mb-1 text-lg text-gray-700 dark:text-white"> <?= count($booths) ?> </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection(); ?>