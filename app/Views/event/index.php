<section class="w-full h-auto relative bg-cover bg-center rounded-md" style="background-image: url('/assets/images/hero.jpg')">
    <!-- Overlay gelap -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="py-10 ml-24 w-72 relative z-10 text-white">
        <h1 class="py-2 text-3xl font-bold">Temukan Event Anime Terdekat di Banjarmasin</h1>
        <p class="py-2 font-thin">Subheading Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo voluptas quos consectetur, autem error quod, ullam rerum dicta aperiam</p>
        <a href="/event/search" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
            Jelajahi Event Sekarang
        </a>
    </div>
</section>

<section class="mt-10 min-h-screen px-10">
    <div class="flex">
        <h1 class="text-2xl font-bold text-white">Event Populer</h1>
    </div>
    <div class="mt-5">
        <div class="hidden sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if (count($events) == 0) :  ?>
                <p>Data event masih kosong</p>    
            <?php endif; ?>
            <?php foreach ($events as $e) : ?>
                <!-- Card Template (ulangi sesuai kebutuhan) -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                        <img class="w-full h-48 object-cover" src="/uploads/images/<?= $e['gambar_event'] ?>" alt="Event Image" />
                    </a>
                    <div class="p-5">
                        <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= esc($e['judul_event']) ?> </h5>
                        </a>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📍<?= esc($e['tanggal_event']) ?></p>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📅<?= esc($e['lokasi_event']) ?></p>
                        <?php if ($e['harga_tiket'] == 0): ?>
                            <p class="mb-3 text-lg font-bold text-green-400">🏷️Gratis</p>
                        <?php else: ?>
                            <p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">🏷️Rp<?= esc(number_format($e['harga_tiket'], 0, ',', '.')) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center border-t pt-3 border-secondary-main">
                            <img class="w-10 h-10 rounded-full shadow mr-3" src="/uploads/images/<?= $e['gambar_event'] ?>" alt="Organizer" />
                            <p class="text-sm text-gray-700 dark:text-gray-400"><?= $e['organizer'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="sm:hidden flex overflow-x-auto space-x-4 px-2 snap-x snap-mandatory">
        <?php if (count($events) == 0) :  ?>
            <p>Data event masih kosong</p>    
        <?php endif; ?>
        
        <?php foreach ($events as $e) : ?>
            <div class="min-w-[16rem] snap-center shrink-0">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                        <img class="w-full h-48 object-cover" src="/uploads/images/<?= $e['gambar_event'] ?>" alt="Event Image" />
                    </a>
                    <div class="p-5">
                        <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= esc($e['judul_event']) ?> </h5>
                        </a>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📍<?= esc($e['tanggal_event']) ?></p>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📅<?= esc($e['lokasi_event']) ?></p>
                        <?php if ($e['harga_tiket'] == 0): ?>
                            <p class="mb-3 text-lg font-bold text-green-400">🏷️Gratis</p>
                        <?php else: ?>
                            <p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">🏷️Rp<?= esc(number_format($e['harga_tiket'], 0, ',', '.')) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center border-t pt-3 border-secondary-main">
                            <img class="w-10 h-10 rounded-full shadow mr-3" src="/assets/images/hero.jpg" alt="Organizer" />
                            <p class="text-sm text-gray-700 dark:text-gray-400"><?= $e['organizer'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-10 mb-10 mx-auto">
        <div class="flex items-center justify-center">
        <div class="grid text-center">
            <div class="w-72 text-white">
                <h1 class="py-4 text-2xl font-bold">Punya Event? Tampilkan di Jvent Sekarang</h1>
                <a href="<?= base_url('/event/create') ?>" class="px-2 py-2 text-center bg-gradient-to-r from-tertiary-soft to-violet-600 text-white rounded-lg font-semibold hover:opacity-90 transition">
                    Daftarkan Event Anda
                </a>
            </div>
        </div>
    </div>

    <!-- cardview -->
</section>