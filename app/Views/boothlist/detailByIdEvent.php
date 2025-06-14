<div class="max-w-7xl mx-auto p-6 text-white border-2 rounded-lg shadow-md border-secondary-main my-10">
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Detail Booth yang Tersedia</h2>
    <?php if (!empty($booths)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-300">
                <thead>
                    <tr class="bg-gray-700 text-gray-200 uppercase text-xs">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Gambar</th>
                        <th class="px-4 py-3">Nama Booth</th>
                        <th class="px-4 py-3">Harga Sewa</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($booths as $booth): ?>
                    <tr class="bg-gray-900 border-b border-gray-700">
                        <td class="px-4 py-3"> <?= $no++ ?> </td>
                        <td class="px-4 py-3">
                            <?php if (!empty($booth['gambar_booth'])): ?>
                                <img src="/uploads/images/<?= esc($booth['gambar_booth']) ?>" alt="<?= esc($booth['nama_booth']) ?>" class="rounded-md w-16 h-12 object-cover object-center border border-gray-200 dark:border-gray-700">
                            <?php else: ?> 
                                <img src="/uploads/images/default_booth.jpg" alt="Default Booth Image" class="rounded-md w-16 h-12 object-cover object-center border border-gray-200 dark:border-gray-700">
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 font-semibold"><?= esc($booth['nama_booth']) ?></td>
                        <td class="px-4 py-3 font-bold">Rp<?= esc(number_format($booth['harga_sewa'], 0, ',', '.')) ?></td>
                        <td class="px-4 py-3 font-bold flex items-center space-x-2">
                            <?php
                                switch ($booth['status']) {
                                    case 'tersedia':
                                        echo '<span class="text-green-400 text-lg">✔</span><span class="text-green-400">Tersedia</span>';
                                        break;
                                    case 'disewa':
                                        echo '<span class="text-red-400 text-lg">✖</span><span class="text-yellow-400">Disewa</span>';
                                        break;
                                    case 'tidak tersedia':
                                        echo '<span class="text-red-400 text-lg">✖</span><span class="text-red-400">Terisi</span>';
                                        break;
                                    default:
                                        echo esc($booth['status']);
                                }
                            ?>
                        </td>
                        <td class="px-4 py-3 font-bold"><?= esc($booth['deskripsi_booth']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-400 mt-8">Tidak ada booth yang tersedia untuk event ini.</p>
    <?php endif; ?>
</div>