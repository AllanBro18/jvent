<div class="p-6 shadow-md max-w-7xl mx-auto border-2 rounded-lg border-secondary-main my-10">
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Detail Booth <?= esc($booth['nama_booth']) ?></h2>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto my-6">
        <table class="min-w-full text-sm text-left text-gray-300">
            <thead>
                <tr class="bg-gray-700 text-gray-200 uppercase text-sm">
                    <th class="px-2 py-2 text-center text-gray-700 dark:text-gray-300">Gambar</th>
                    <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">ID Event</th>
                    <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">Nama Booth</th>
                    <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">Status</th>
                    <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">Deskripsi</th>
                    <th class="px-2 py-2 text-left text-gray-700 dark:text-gray-300">Harga Sewa</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-gray-900 border-b border-gray-700">
                    <td class="px-2 py-2 text-center align-middle">
                        <div class="flex justify-center">
                            <?php if (!empty($booth['gambar_booth'])): ?>
                                <img src="/uploads/images/<?= esc($booth['gambar_booth']) ?>" alt="<?= esc($booth['nama_booth']) ?>" class="rounded-md w-16 h-12 object-cover object-center border border-gray-200 dark:border-gray-700">
                            <?php else: ?> 
                                <img src="/uploads/images/default_booth.jpg" alt="Default Booth Image" class="rounded-md w-16 h-12 object-cover object-center border border-gray-200 dark:border-gray-700">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-2 py-2"><?= esc($booth['id_event']) ?></td>
                    <td class="px-2 py-2 font-semibold text-gray-900 dark:text-white"><?= esc($booth['nama_booth']) ?></td>
                    <td class="px-2 py-2 font-bold">
                        <?php
                            switch ($booth['status']) {
                                case 'tersedia':
                                    echo '<span class="text-green-500">Tersedia</span>';
                                    break;
                                case 'disewa':
                                    echo '<span class="text-yellow-500">Disewa</span>';
                                    break;
                                case 'tidak tersedia':
                                    echo '<span class="text-red-500">Terisi</span>';
                                    break;
                                default:
                                    echo esc($booth['status']);
                            }
                        ?>
                    </td>
                    <td class="px-2 py-2"><?= esc($booth['deskripsi_booth']) ?></td>
                    <td class="px-2 py-2">Rp<?= esc(number_format($booth['harga_sewa'], 0, ',', '.')) ?></td>
                </tr>
            </tbody>
        </table>
            <?php if (empty($booth)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-white">Tidak ada data booth yang tersedia.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>