<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<section class="max-w-4xl mx-auto p-6 border-2 rounded-lg shadow-md border-secondary-main mt-10">
    <!-- Include Alert View -->
    <?= view('components/alert') ?>
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Tambah Event Baru</h2>
    <form action="/event/save" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?= csrf_field() ?>

        <!-- Judul Event -->
        <div>
            <label for="judul_event" class="block mb-2 text-white text-sm font-medium">Nama Event</label>
            <input 
                type="text" 
                id="judul_event" 
                name="judul_event" 
                autofocus
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Gambar Event -->
        <div>
            <label for="gambar_event" class="block mb-2 text-white text-sm font-medium">Gambar Event</label>
            <input
                type="file"
                id="gambar_event"
                name="gambar_event"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main <?= \Config\Services::validation()->hasError('gambar_event') ? 'border-red-500' : '' ?>"
            />
            <?php if(\Config\Services::validation()->hasError('gambar_event')): ?>
                <p class="text-red-500 text-xs mt-1"><?= \Config\Services::validation()->getError('gambar_event') ?></p>
            <?php endif; ?>
        </div>

        <!-- Tanggal Event -->
        <div>
            <label for="tanggal_event" class="block mb-2 text-white text-sm font-medium">Tanggal Event</label>
            <input 
                type="date" 
                id="tanggal_event" 
                name="tanggal_event" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Lokasi Event -->
        <div class="md:col-span-2">
            <label for="lokasi_event" class="block mb-2 text-white text-sm font-medium">Lokasi Event</label>
            <input 
                type="text" 
                id="lokasi_event" 
                name="lokasi_event" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Harga Tiket -->
        <div>
            <label for="harga_tiket" class="block mb-2 text-white text-sm font-medium">Harga Tiket</label>
            <input 
                type="number" 
                id="harga_tiket" 
                name="harga_tiket" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Kategori Tiket -->
        <div>
            <label for="kategori_tiket" class="block mb-2 text-white text-sm font-medium">Kategori Tiket</label>
            <input 
                type="text" 
                id="kategori_tiket" 
                name="kategori_tiket" 
                placeholder="Berbayar/Gratis"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Link Tiket -->
        <div class="md:col-span-2">
            <label for="link_tiket" class="block mb-2 text-white text-sm font-medium">Link Pembelian Tiket</label>
            <input 
                type="url" 
                id="link_tiket" 
                name="link_tiket" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            />
        </div>

        <!-- Deskripsi Event -->
        <div class="md:col-span-2">
            <label for="deskripsi_event" class="block mb-2 text-white text-sm font-medium">Deskripsi Event</label>
            <textarea 
                name="deskripsi_event" 
                rows="4" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
            </textarea>
        </div>

        <!-- Sponsor -->
        <div class="md:col-span-2">
            <label for="sponsor" class="block mb-2 text-white text-sm font-medium">Sponsor</label>
            <textarea 
                name="sponsor" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
            </textarea>
        </div>

        <!-- Guest Star -->
        <div class="md:col-span-2">
            <label for="guest_star" class="block mb-2 text-white text-sm font-medium">Guest Star</label>
            <textarea 
                name="guest_star" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
            </textarea>
        </div>

        <!-- Booth List -->
        <div class="md:col-span-2">
            <label for="booth_list" class="block mb-2 text-white text-sm font-medium">Booth List</label>
            <textarea 
                name="booth_list" 
                rows="2" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
            </textarea>
        </div>

        <!-- Submit Button -->
        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Buat Event
            </button>
        </div>

    </form>
</section>

<?= $this->endSection() ?>