<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<section class="max-w-4xl mx-auto p-6 border-2 rounded-lg shadow-md border-secondary-main my-10">
    <?php $validation = session('validation'); ?>
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Ubah Booth</h2>
        <form action="<?= base_url('/boothlist/update/' . $booth['id_booth']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <!-- Nama Booth -->
        <div class="md:col-span-2">
            <label for="judul_event" class="block mb-2 text-white text-sm font-medium">Nama Booth</label>
            <input 
                type="text" 
                id="nama_booth" 
                name="nama_booth" 
                autofocus
                value="<?= (old('nama_booth') ? old('nama_booth') : $booth['nama_booth']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
            >
            <?php if (session('validation') && session('validation')->hasError('nama_booth')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('nama_booth'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Event Dropdown -->
        <div class="md:col-span-2">
            <label for="id_event" class="block mb-2 text-white text-sm font-medium">Pilih Event</label>
            <select id="id_event" name="id_event" class="w-full bg-secondary-main text-white py-2 px-4 rounded text-sm">
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id_event']; ?>" <?= old('id_event') == $event['id_event'] ? 'selected' : '' ?>>
                        <?= esc($event['judul_event']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (session('validation') && session('validation')->hasError('id_event')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('id_event'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Gambar Booth -->
        <div class="md:col-span-2">
            <label for="gambar_event" class="block mb-2 text-white text-sm font-medium">Gambar Event Sebelumnya</label>
            <!-- Preview Gambar Lama -->
            <?php if ($booth['gambar_booth']) : ?>
                <div class="mb-2">
                    <img src="/uploads/images/<?= $booth['gambar_booth'] ?>" alt="Gambar Event Lama" class="h-32 object-cover rounded-md">
                </div>
            <?php endif; ?>
            <label for="" class="block mb-2 text-white text-sm font-medium">
                Upload gambar baru
            </label>
            <input
                type="file"
                id="gambar_booth"
                name="gambar_booth"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main <?= \Config\Services::validation()->hasError('gambar_booth') ? 'border-red-500' : '' ?>"
            />
            <?php if (session('validation') && session('validation')->hasError('gambar_booth')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('gambar_booth'); ?>
                </p>
            <?php endif; ?>
        </div>
        <input type="hidden" name="gambar_lama" value="<?= $booth['gambar_booth']; ?>">

        <!-- Harga Sewa -->
        <div class="">
            <label for="harga_sewa" class="block mb-2 text-white text-sm font-medium">Harga Sewa</label>
            <input 
                type="number" 
                id="harga_sewa" 
                name="harga_sewa" 
                value="<?= (old('harga_sewa') ? old('harga_sewa') : $booth['harga_sewa']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
                placeholder="Contoh: 250000"
            />
            <?php if (session('validation') && session('validation')->hasError('harga_sewa')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('harga_sewa'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Status -->
        <div class="">
            <label for="status" class="block mb-2 text-white text-sm font-medium">Status Booth</label>
            <select id="status" name="status" class="w-full bg-secondary-main text-white py-2 px-4 rounded text-sm">
                <option value="">-- Pilih Status --</option>
                <option value="tersedia" <?= old('status') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="disewa" <?= old('status') == 'disewa' ? 'selected' : '' ?>>Disewa</option>
                <option value="tidak tersedia" <?= old('status') == 'tidak tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
            </select>
            <?php if (session('validation') && session('validation')->hasError('status')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('status'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Deskripsi Booth -->
        <div class="md:col-span-2">
            <label for="deskripsi_booth" class="block mb-2 text-white text-sm font-medium">Deskripsi Booth</label>
            <textarea 
                name="deskripsi_booth" 
                rows="4" 
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
                <?= (old('deskripsi_booth') ? old('deskripsi_booth') : $booth['deskripsi_booth']) ?>
            </textarea>
            <?php if (session('validation') && session('validation')->hasError('deskripsi_booth')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('deskripsi_booth'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Simpan Booth
            </button>
        </div>

    </form>
</section>
<?= $this->endSection() ?>