<section class="text-white min-h-screen px-6 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Gambar dan Deskripsi -->
        <div class="md:col-span-2">
            <img src="/uploads/images/<?= $events['gambar_event'] ?>" alt="" class="rounded-xl mb-6 w-full object-cover">

            <h2 class="text-xl font-bold mb-3">Deskripsi Event</h2>
            <p class="leading-relaxed text-justify">
                <?= $events['deskripsi_event'] ?>
            </p>
            <br>
            <p class="leading-relaxed text-justify">
                <?= $events['booth_list'] ?>
            </p>
            <br>
            <p class="leading-relaxed text-justify">
                <?= $events['guest_star'] ?>
            </p>
            <br>
            <p class="leading-relaxed text-justify">
                <?= $events['sponsor'] ?>
            </p>
            
            
            <?php
                // Filter booth yang sesuai dengan event saat ini
                $filteredBooths = array_filter($booths, function($booth) use ($events) {
                    return $booth['id_event'] == $events['id_event'];
                });
            ?>

            <h2 class="text-xl font-bold my-3">Booth yang Tersedia</h2>
            <?php if (!empty($filteredBooths)): ?>
               <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-300">
                        <thead>
                            <tr class="bg-gray-700 text-gray-200 uppercase text-xs">
                                <th class="px-4 py-3">Gambar</th>
                                <th class="px-4 py-3">Nama Booth</th>
                                <th class="px-4 py-3">Harga Sewa</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($filteredBooths as $booth): ?>
                            <tr class="bg-gray-900 border-b border-gray-700">
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
                                <td class="px-4 py-3 font-light"><?= esc($booth['deskripsi_booth']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <table class="min-w-full text-sm text-gray-300">
                    <tr class="bg-gray-900 border-b border-gray-700">
                        <td colspan="6" class="px-4 py-3 text-left">Tidak ada booth yang tersedia untuk event ini.</td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>

        <!-- Kartu Event -->
        <aside class="bg-secondary-main rounded-xl p-6 space-y-6 h-fit shadow-md">
            <div>
                <h3 class="text-2xl font-bold mb-2"><?= $events['judul_event'] ?></h3>
                <div class="text-sm space-y-1">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-secondary-second" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-base"><?= $events['tanggal_event'] ?></span>
                </div>
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-secondary-second" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    <span class="text-base"><?= $events['lokasi_event'] ?></span>
                </div>
                <!-- <div class="flex items-center  gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-secondary-second" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 2M12 6a9 9 0 100 18 9 9 0 000-18z"/></svg>
                    <span class="text-base">13:00 - 21:00 WITA</span>
                </div> -->
                <?php if ($events['harga_tiket'] == 0): ?>
                    <p class="mt-4 text-sm font-semibold text-green-400">🏷️Gratis</p>
                <?php else: ?>
                    <p class="mt-4 text-sm font-semibold text-gray-900 dark:text-white">🏷️Rp<?= esc(number_format($events['harga_tiket'], 0, ',', '.')) ?></p>
                <?php endif; ?>
                <p class="text-xs mt-1 text-gray-400">Diselenggarakan oleh</p>
                <div class="flex gap-2 mt-1 items-center">
                    <img src="<?= base_url('/uploads/images/' . $events['gambar_event']) ?>" alt="" class="h-5">
                    <span class="text-sm font-bold"><?= $events['organizer'] ?></span>
                </div>
            </div>

            <!-- Tiket Event -->
            <div class="p-4 rounded-xl">
                <h4 class="text-base font-semibold mb-2">Tiket Event</h4>
                <a href="<?= $events['link_tiket'] ?>" target="_blank" class="block text-center bg-gradient-to-r from-tertiary-hard to-violet-600 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    PEMBELIAN TIKET
                </a>
            </div>
        </aside>
    </div>
</section>