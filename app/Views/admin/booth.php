<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:ml-64">
    <div class="flex flex-col md:flex-row text-white min-h-screen">
        <!-- Content -->
        <main class="flex-1 p-5 sm:p-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <div class="text-center space-y-4">
                    <h2 class="text-xl sm:text-2xl font-semibold">Booth Saya</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-gray-700 px-4 py-2 rounded"><?= esc($username_admin) ?></div>
                    <a href="/booth/create" class="bg-gradient-to-r from-tertiary-soft to-violet-600 hover:opacity-90 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Buat Booth</a>
                </div>
            </div>

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
                            <form action="/booth/<?= $b['id_booth'] ?>" method="post" class="my-1 md:mx-1">
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
</div>

<?= $this->endSection() ?>