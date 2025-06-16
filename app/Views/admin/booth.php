<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="w-full">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="md:w-1/5 w-full md:h-screen border-b md:border-b-0 md:border-r-2 border-secondary-second p-4 text-center">
            <h2 class="font-bold text-white border-b-2 border-secondary-second pb-2">Filter</h2>

            <!-- Modern Dropdown (Always Visible) -->
            <div class="relative mt-5">
                <div class="w-full text-white bg-gradient-to-r from-tertiary-hard to-blue-800 font-semibold rounded-t-lg text-sm px-4 py-2.5 flex justify-between items-center dark:bg-blue-600">
                    <span>Kategori</span>
                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </div>
                <!-- Dropdown menu (Always Visible) -->
                <div class="bg-white rounded-b-lg shadow-lg w-full dark:bg-gray-700 border-t-0 border border-blue-800">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li>
                            <a href="/event/filter/gratis/all"
                               class="flex items-center gap-2 px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors rounded-md">
                                <span class="inline-block w-2 h-2 bg-green-400 rounded-full"></span>
                                <span class="font-medium">Event Gratis</span>
                            </a>
                        </li>
                        <li>
                            <a href="/event/filter/all/terbaru"
                               class="flex items-center gap-2 px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors rounded-md">
                                <span class="inline-block w-2 h-2 bg-blue-400 rounded-full"></span>
                                <span class="font-medium">Event Terbaru</span>
                            </a>
                        </li>
                        <li>
                            <a href="/event/filter/berbayar/all"
                               class="flex items-center gap-2 px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors rounded-md">
                                <span class="inline-block w-2 h-2 bg-yellow-400 rounded-full"></span>
                                <span class="font-medium">Event Berbayar</span>
                            </a>
                        </li>
                        <li>
                            <a href="/booth" class="flex items-center gap-2 px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors rounded-md">
                                <span class="inline-block w-2 h-2 bg-red-400 rounded-full"></span>
                                <span class="font-medium">Booths</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="md:w-4/5 w-full p-4 text-white">
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php if (count($booths) == 0) :  ?>
                    <div id="notFoundToast" class="fixed bg-red-600 text-white px-4 py-3 rounded shadow-lg hidden z-50">
                        Booth yang Anda cari tidak ada. Coba kata kunci lain.
                    </div>
                <?php endif; ?>

                <?php foreach ($booths as $b) : ?>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                        <a href="/booth/<?= esc($b['slug']) ?>" target="_blank">
                            <img class="w-full h-48 object-cover" src="/uploads/images/<?= $b['gambar_booth'] ?>" alt="Booth Image" />
                        </a>
                        <div class="p-5">
                            <a href="/booth/<?= esc($b['slug']) ?>" target="_blank">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= esc($b['nama_booth']) ?> </h5>
                            </a>
                            <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">Booth: <?= esc($b['jenis_booth']) ?></p>
                        </div>
                        <div class="flex flex-col md:flex-row items-start md:items-end">
                                    <a href="<?= base_url('booth/edit/' . $b['slug']) ?>" class="my-1 md:mx-1 bg-gradient-to-r from-tertiary-hard to-blue-600 hover:opacity-90 text-white px-3 py-1 rounded hover:bg-purple-700 transition">Edit</a>
                                    <form action="/booth/<?= $b['slug'] ?>" method="post" class="my-1 md:mx-1">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" onclick="return confirm('Apakah anda yakin menghapus booth ini?')" class="bg-red-600 px-2 py-1 rounded hover:bg-red-700 text-white">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                    </div>
                <?php endforeach; ?>
            </div>

            
        </main>

    </div>

</section>

<?= $this->endSection() ?>