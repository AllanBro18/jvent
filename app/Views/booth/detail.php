<section class="min-h-screen bg-[#23243a] px-4 py-8 text-white">
    <!-- Banner Booth -->
    <div class="max-w-6xl mx-auto mb-8">
        <div class="relative group bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <img src="/uploads/images/<?= $booth['gambar_booth'] ?>" alt="<?= esc($booth['nama_booth']) ?>" class="w-full h-64 object-cover">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-1"><?= esc($booth['nama_booth']) ?></h2>
                        <div class="text-sm text-gray-300 mb-2">
                            Fandom: <?= esc($booth['deskripsi_booth']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Left (Sticky) & Right (Scrollable) -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Left Column (Sticky) -->
        <aside class="md:col-span-1 relative">
            <div class="md:sticky md:top-24 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden p-6 space-y-6">
                <!-- Logo Booth -->
                <div class="flex items-center space-x-3">
                    <img src="/uploads/images/<?= $booth['logo_booth'] ?? $booth['gambar_booth'] ?>" alt="Logo Booth" class="w-14 h-14 rounded-full object-cover border-2 border-secondary-main">
                    <span class="text-xl font-bold"><?= esc($booth['nama_booth']) ?></span>
                </div>
                <!-- Deskripsi -->
                <div>
                    <div class="font-semibold mb-1">Deskripsi:</div>
                    <p class="text-gray-200 text-sm"><?= esc($booth['deskripsi_booth']) ?></p>
                </div>
                <!-- Lokasi Booth -->
                <div>
                    <div class="font-semibold mb-1">Lokasi Booth:</div>
                    <div class="text-gray-200 text-sm"><?= esc($booth['lokasi_booth']) ?></div>
                </div>
                <!-- Hubungi Kami -->
                <div>
                    <div class="font-semibold mb-1">Hubungi Kami:</div>
                    <div class="flex space-x-3 mt-1">
                        <?php if (!empty($booth['instagram'])): ?>
                            <a href="<?= esc($booth['instagram']) ?>" target="_blank" class="hover:opacity-80">
                                <img src="/assets/icons/instagram.svg" alt="Instagram" class="w-6 h-6">
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($booth['twitter'])): ?>
                            <a href="<?= esc($booth['twitter']) ?>" target="_blank" class="hover:opacity-80">
                                <img src="/assets/icons/twitter.svg" alt="Twitter" class="w-6 h-6">
                            </a>
                        <?php endif; ?>
                        <!-- Tambahkan kontak lain jika ada -->
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right Column (Scrollable) -->
        <main class="md:col-span-2">
            <?php if (!empty($produk)) : ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Gambar</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Produk
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stok
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Harga
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Deskripsi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $p): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-4">
                                <img src="/uploads/images/produk/<?= $p['gambar_produk'] ?? $p['gambar_produk'] ?>" alt="Gambar Produk" class=" w-16 md:w-20 max-w-full max-h-full" alt="Apple Watch">
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <?= esc($p['nama_produk']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div>
                                        <span class="bg-gray-50 w-14 text-center border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <?= esc($p['stok']) ?> pcs
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                Rp<?= esc(number_format($p['harga'], 0, ',', '.')) ?>
                            </td>
                            <td class="px-6 py-4 font-sm font-semibold text-gray-200">
                                <?= esc($p['status']) ?>
                            </td>
                            <td class="px-6 py-4 font-sm font-light text-gray-200">
                                <?= esc($p['deskripsi']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <p class="text-gray-400">Tidak ada booth yang tersedia untuk event ini.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</section>