<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<section class="max-w-4xl mx-auto p-6 border-2 rounded-lg shadow-md border-secondary-main my-10">
    <?php $validation = session('validation'); ?>
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Ubah Event</h2>
    <?php if (!isset($events['id_event'])) : ?>
        <p class="text-red-500">Data event tidak ditemukan.</p>
    <?php else : ?>

    <form action="<?= base_url('/event/update/' . $events['id_event']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- parameter slug yang dikirim ke event/update -->
        <input type="hidden" name="slug" value="<?= $events['slug'] ?>">

        <!-- Judul Event -->
        <div class="md:col-span-2">
            <label for="judul_event" class="block mb-2 text-white text-sm font-medium">Judul Event</label>
            <input 
                type="text" 
                id="judul_event" 
                name="judul_event" 
                autofocus
                value="<?= (old('judul_event') ? old('judul_event') : $events['judul_event']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            >
            <?php if (session('validation') && session('validation')->hasError('judul_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('judul_event'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Organizer Event -->
        <div class="md:col-span-2">
            <label for="organizer" class="block mb-2 text-white text-sm font-medium">Organizer</label>
            <input 
                type="text" 
                id="organizer" 
                name="organizer" 
                value="<?= (old('organizer') ? old('organizer') : $events['organizer']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            >
            <?php if (session('validation') && session('validation')->hasError('organizer')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('organizer'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Gambar Event -->
        <div class="md:col-span-2">
            <label for="gambar_event" class="block mb-2 text-white text-sm font-medium">Gambar Event Sebelumnya</label>
            <!-- Preview Gambar Lama -->
            <?php if ($events['gambar_event']) : ?>
                <div class="mb-2">
                    <img src="/uploads/images/<?= $events['gambar_event'] ?>" alt="Gambar Event Lama" class="h-32 object-cover rounded-md">
                </div>
            <?php endif; ?>
            <label for="" class="block mb-2 text-white text-sm font-medium">
                Upload gambar baru
            </label>
            <input
                type="file"
                id="gambar_event"
                name="gambar_event"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main <?= \Config\Services::validation()->hasError('gambar_event') ? 'border-red-500' : '' ?>"
            />
            <?php if (session('validation') && session('validation')->hasError('gambar_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('gambar_event'); ?>
                </p>
            <?php endif; ?>
        </div>
        <input type="hidden" name="gambar_lama" value="<?= $events['gambar_event']; ?>">

        <!-- Tanggal Event -->
        <div class="md:col-span-2">
            <label for="tanggal_event" class="block mb-2 text-white text-sm font-medium">Tanggal Event</label>
            <input 
                type="date" 
                id="tanggal_event" 
                name="tanggal_event" 
                value="<?= (old('tanggal_event') ? old('tanggal_event') : $events['tanggal_event']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
            <?php if (session('validation') && session('validation')->hasError('tanggal_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('tanggal_event'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Lokasi Event -->
        <div class="md:col-span-2">
            <label for="lokasi_event" class="block mb-2 text-white text-sm font-medium">Lokasi Event</label>
            <input 
                type="text" 
                id="lokasi_event" 
                name="lokasi_event" 
                value="<?= (old('lokasi_event') ? old('lokasi_event') : $events['lokasi_event']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
            <?php if (session('validation') && session('validation')->hasError('lokasi_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('lokasi_event'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Kategori tiket dan Harga tiket -->
        <div class="md:col-span-2">
            <label for="kategori_tiket" class="block mb-2 text-white text-sm font-medium">Kategori Tiket</label>
            <select id="kategori_tiket" name="kategori_tiket" onchange="toggleHargaTiket()" class="w-full bg-secondary-main text-white py-2 px-4 rounded text-sm">
                <option value="">-- Pilih Kategori --</option>
                <option value="gratis">Gratis</option>
                <option value="berbayar">Berbayar</option>
                <?= (old('kategori_tiket') ? old('kategori_tiket') : $events['kategori_tiket']) ?>
            </select>
            <?php if (session('validation') && session('validation')->hasError('kategori_tiket')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('kategori_tiket'); ?>
                </p>
            <?php endif; ?>
        </div>

        <div id="harga_tiket_wrapper" style="display: none;" class="md:col-span-2">
            <label for="harga_tiket" class="block mb-2 text-white text-sm font-medium">Harga Tiket</label>
            <input 
                type="number" 
                id="harga_tiket" 
                name="harga_tiket" 
                value="<?= (old('harga_tiket') ? old('harga_tiket') : $events['harga_tiket']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
                placeholder="Contoh: 25000"
            >
            <?php if (session('validation') && session('validation')->hasError('harga_tiket')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('harga_tiket'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Link Tiket -->
        <div class="md:col-span-2">
            <label for="link_tiket" class="block mb-2 text-white text-sm font-medium">Link Pembelian Tiket</label>
            <input 
                type="url" 
                id="link_tiket" 
                name="link_tiket" 
                value="<?= (old('link_tiket') ? old('link_tiket') : $events['link_tiket']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
            <?php if (session('validation') && session('validation')->hasError('link_tiket')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('link_tiket'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Deskripsi Event -->
        <div class="md:col-span-2">
            <label for="deskripsi_event" class="block mb-2 text-white text-sm font-medium">Deskripsi Event</label>
            <textarea 
                name="deskripsi_event" 
                rows="4" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
                <?= (old('deskripsi_event') ? old('deskripsi_event') : $events['deskripsi_event']) ?>
            </textarea>
            <?php if (session('validation') && session('validation')->hasError('deskripsi_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('deskripsi_event'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Sponsor -->
        <div class="md:col-span-2">
            <label for="sponsor" class="block mb-2 text-white text-sm font-medium">Sponsor</label>
            <textarea 
                name="sponsor" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
                <?= (old('sponsor') ? old('sponsor') : $events['sponsor']) ?>
            </textarea>
            <?php if (session('validation') && session('validation')->hasError('sponsor')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('sponsor'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Guest Star -->
        <div class="md:col-span-2">
            <label for="guest_star" class="block mb-2 text-white text-sm font-medium">Guest Star</label>
            <textarea 
                name="guest_star" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
                <?= (old('guest_star') ? old('guest_star') : $events['guest_star']) ?>
            </textarea>
            <?php if (session('validation') && session('validation')->hasError('guest_star')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('guest_star'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Booth List -->
        <div class="md:col-span-2">
            <label for="booth_list" class="block mb-2 text-white text-sm font-medium">Booth List</label>
            <textarea 
                name="booth_list" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
                <?= (old('booth_list') ? old('booth_list') : $events['booth_list']) ?>
            </textarea>
            <?php if (session('validation') && session('validation')->hasError('booth_list')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('booth_list'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Simpan Perubahan
            </button>
        </div>

    </form>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>