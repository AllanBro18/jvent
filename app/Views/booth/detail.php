<section class="text-white min-h-screen px-6 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Gambar dan Deskripsi -->
        <div class="md:col-span-2">
            <img src="/uploads/images/<?= $booth['gambar_booth'] ?>" alt="" class="rounded-xl mb-6 w-full object-cover">

            <h2 class="text-xl font-bold mb-3">Deskripsi Booth</h2>
            <p class="leading-relaxed text-justify">
                <?= $booth['deskripsi_booth'] ?>
            </p>
            <br>
        </div>

        <!-- Kartu Event -->
        <aside class="bg-secondary-main rounded-xl p-6 space-y-6 h-fit shadow-md">
            <div>
                <h3 class="text-2xl font-bold mb-2"><?= $booth['nama_booth'] ?></h3>
                <div class="text-sm space-y-1">
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-secondary-second" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    <span class="text-base"><?= $booth['lokasi_booth'] ?></span>
                </div>
                <div class="flex items-center gap-2 text-gray-300">
                    <svg class="w-4 h-4 text-secondary-second" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 12l-8-5v10l8 5 8-5V7l-8 5z"/><path d="M12 12l8-5m0 10l-8-5"/></svg>
                    <span class="text-base"><?= $booth['jenis_booth'] ?></span>
                </div>
            </div>

            <!-- Tiket Event -->
            <div class="p-4 rounded-xl">
                <h4 class="text-base font-semibold mb-2">Kontak Booth</h4>
                <a href="<?= $booth['kontak_booth'] ?>" target="_blank" class="block text-center bg-gradient-to-r from-tertiary-hard to-violet-600 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Hubungi Booth
                </a>
            </div>
        </aside>
    </div>
</section>