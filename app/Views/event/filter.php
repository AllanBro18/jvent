<section class="w-full">
  <div class="flex flex-col md:flex-row">
    <!-- Sidebar -->
    <aside class="md:w-1/5 w-full md:h-screen border-b md:border-b-0 md:border-r-2 border-secondary-second p-4 text-center">
        <h2 class="font-bold text-white border-b-2 border-secondary-second pb-2">Filter</h2>

        <!-- Wrapper Dropdown -->
        <div class="relative mt-5">
        <!-- Button -->
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex justify-between items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Kategori Harga
            <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdown"
            class="absolute z-10 hidden mt-2 w-full bg-white divide-y divide-gray-100 rounded-lg shadow-md dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <li>
                <a href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Berbayar</a>
            </li>
            <li>
                <a href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Gratis</a>
            </li>
            </ul>
        </div>
        </div>

    </aside>

    <!-- Content -->
    <main class="md:w-4/5 w-full p-4 text-white">
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php if (count($event) == 0) :  ?>
                <p>Data event masih kosong</p>    
            <?php endif; ?>
            <?php foreach ($event as $e) : ?>
                <!-- Card Template (ulangi sesuai kebutuhan) -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                        <img class="w-full h-48 object-cover" src="/assets/images/hero.jpg" alt="Event Image" />
                    </a>
                    <div class="p-5">
                        <a href="/event/<?= esc($e['slug']) ?>" target="_blank">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= esc($e['judul_event']) ?> </h5>
                        </a>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= esc($e['tanggal_event']) ?></p>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= esc($e['lokasi_event']) ?></p>
                        <p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">Rp<?= esc($e['harga_tiket']) ?></p>
                        <div class="flex items-center border-t pt-3 border-secondary-main">
                            <img class="w-10 h-10 rounded-full shadow mr-3" src="/assets/images/hero.jpg" alt="Organizer" />
                            <p class="text-sm text-gray-700 dark:text-gray-400">Imagi</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
  </div>
</section>
