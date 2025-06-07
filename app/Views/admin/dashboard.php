<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
    <div class="flex-1 flex-col md:flex-row">
        <!-- Main Con6tent -->
        <main class="flex-1 p-5 sm:p-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <h2 class="text-xl sm:text-2xl font-semibold">Event Saya</h2>
                <div class="flex items-center space-x-4">
                    <div class="bg-gray-700 px-4 py-2 rounded"><?= esc($username_admin) ?></div>
                    <a href="/event/create" class="bg-gradient-to-r from-tertiary-soft to-violet-600 hover:opacity-90 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Buat Event</a>
                    <a href="/logout" onclick="return confirm('Apakah anda yakin logout?')" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Logout</a>
                </div>
            </div>

            <!-- Search and Sort -->
            <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4 mb-8">
                <div class="w-full sm:w-1/2 relative">
                    <form action="" method="post">
                        <input
                        type="text"
                        placeholder="Cari event kamu disini"
                        name="keyword"
                        class="w-full py-2 pl-10 pr-4 rounded bg-gray-700 placeholder-gray-300 text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </form>
                </div>
                
                <div>
                    <label class="mr-2 text-sm text-gray-300">Urutkan:</label>
                    <form action="" method="post">
                        <select name="sort" onchange="this.form.submit()" class="bg-secondary-main text-white py-2 px-4 rounded text-sm">
                            <option>Waktu Mulai (Terdekat)</option>
                            <option value="asc">Nama Event (A-Z)</option>
                            <option value="">Terbaru</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-6 mb-6 border-b border-gray-700 text-sm sm:text-base">
                <a href="#" class="border-b-2 border-white pb-2 font-semibold">EVENT AKTIF</a>
                <a href="#" class="text-gray-400 pb-2 hover:text-white">EVENT LALU</a>
            </div>

            <!-- Event Cards -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                
                <?php foreach ($event as $e): ?>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                        <a href="/event/<?= $e['slug'] ?>" target="_blank">
                            <img class="w-full h-48 object-cover" src="/uploads/images/<?= $e['gambar_event'] ?>" alt="Event Image" />
                        </a>
                        <div class="p-5">
                            <a href="/event/<?= $e['slug'] ?>" target="_blank">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= $e['judul_event'] ?> </h5>
                            </a>
                            <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= $e['tanggal_event'] ?></p>
                            <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= $e['lokasi_event'] ?></p>
                            <?php if ($e['harga_tiket'] == 0): ?>
                                <p class="mb-3 text-lg font-bold text-green-400">🏷️Gratis</p>
                            <?php else: ?>
                                <p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">🏷️Rp<?= esc(number_format($e['harga_tiket'], 0, ',', '.')) ?></p>
                            <?php endif; ?>
                            <div class="flex justify-between border-t pt-3 border-secondary-main">
                                <div class="flex items-center ">
                                    <img class="w-10 h-10 rounded-full shadow mr-3" src="/assets/images/hero.jpg" alt="Organizer" />
                                    <p class="text-sm text-gray-700 dark:text-gray-400"><?= $e['organizer'] ?></p>
                                </div>
                                <div class="flex items-end">
                                    <a href="<?= base_url('/event/edit/' . $e['slug']) ?>" class="mx-1 bg-gradient-to-r from-tertiary-hard to-blue-600 hover:opacity-90 text-white px-3 py-1 rounded hover:bg-purple-700 transition">Edit</a>
                                    <form action="/event/<?= $e['id_event'] ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" onclick="return confirm('Apakah anda yakin menghapus event ini?')" class="mx-1 bg-red-600 px-1 py-1 rounded hover:bg-red-700">
                                            <p>Delete</p>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Footer Text -->
            <div class="mt-10 text-center space-y-3">
                <a href="/event/create" class="bg-gradient-to-r from-tertiary-soft to-violet-600 hover:opacity-90 px-6 py-3 rounded font-semibold">Buat Event</a>
                <p class="text-lg font-semibold">Hai, terima kasih telah menggunakan Jvent</p>
                <p class="text-sm text-gray-400">Silahkan Buat Event Mu dengan klik Button Diatas!</p>
            </div>
        </main>
    </div>
<?= $this->endSection() ?>