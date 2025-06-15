<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:ml-64">
    <div class="flex flex-col md:flex-row text-white min-h-screen">
        <div class="rounded-lg p-6 shadow-md">
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Admin Panel</h2>
                <!-- tambah admin -->
                
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-600 text-white px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="bg-red-600 text-white px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty(session('username_admin'))): ?>
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-sm text-left text-gray-300 border-collapse">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="px-6 py-3 border-b border-gray-700">#</th>
                            <th class="px-6 py-3 border-b border-gray-700">ID</th>
                            <th class="px-6 py-3 border-b border-gray-700">Username</th>
                            <th class="px-6 py-3 border-b border-gray-700">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 border-b border-gray-700"><?= $no++ ?></td>
                            <td class="px-6 py-4 border-b border-gray-700"><?= esc($admin['id_admin']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-700"><?= esc($admin['username_admin']) ?></td>
                            <td class="px-6 py-4 border-b border-gray-700"><?= esc($admin['email_admin']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <p class="text-gray-400">Tidak ada admin yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
