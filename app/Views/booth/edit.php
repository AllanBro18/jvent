<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<section class="max-w-4xl mx-auto p-6 border-2 rounded-lg shadow-md border-secondary-main mt-10">
    <?php $validation = session('validation'); ?>
    <h2 class="text-2xl text-secondary-second font-semibold mb-6 border-b-2 border-secondary-main">Edit Booth</h2>
    <form action="<?= base_url('/booth/update/' . $booth['id_booth']) ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- parameter slug yang dikirim ke event/update -->
        <input type="hidden" name="slug" value="<?= $booth['slug'] ?>">

        <!-- Nama Booth -->
        <div class="md:col-span-2">
            <label for="nama_booth" class="block mb-2 text-white text-sm font-medium">Nama Booth</label>
            <label for="nama_booth" class="block mb-2 text-white text-sm font-medium">Nama Booth</label>
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
        
        <!-- Gambar Booth -->
        <div class="md:col-span-2">
            <label for="gambar_booth" class="block mb-2 text-white text-sm font-medium">Gambar Booth Sebelumnya</label>
            <!-- Preview Gambar Lama -->
            <?php if ($booth['gambar_booth']) : ?>
                <div class="mb-2">
                    <img src="/uploads/images/<?= $booth['gambar_booth'] ?>" alt="Gambar Booth Lama" class="h-32 object-cover rounded-md">
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
        <input type="hidden" name="gambar_booth_lama" value="<?= $booth['gambar_booth']; ?>">

        <div class="md:col-span-2">
            <label for="lokasi_booth" class="block mb-2 text-white text-sm font-medium">Lokasi Booth</label>
            <textarea 
            name="lokasi_booth" 
            rows="4" 
            class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main">
            <?= (old('lokasi_booth') ? old('lokasi_booth') : $booth['lokasi_booth']) ?>
        </textarea>
        <?php if (session('validation') && session('validation')->hasError('lokasi_booth')) : ?>
            <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('lokasi_booth'); ?>
            </p>
            <?php endif; ?>
        </div>
        
        <div class="md:col-span-2">
            <label for="kontak_booth" class="block mb-2 text-white text-sm font-medium">Kontak Booth</label>
            <input 
                type="text" 
                id="kontak_booth" 
                name="kontak_booth" 
                value="<?= (old('kontak_booth') ? old('kontak_booth') : $booth['kontak_booth']) ?>"
                class="w-full px-4 py-2 bg-transparent border border-white text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-main"
                placeholder="Contoh: 08123456789"
            />
            <?php if (session('validation') && session('validation')->hasError('kontak_booth')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('kontak_booth'); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="">
            <label for="jenis_booth" class="block mb-2 text-white text-sm font-medium">Jenis Booth</label>
            <select id="jenis_booth" name="jenis_booth" class="w-full bg-secondary-main text-white py-2 px-4 rounded text-sm">
                <option value="">-- Pilih Jenis --</option>
                <option value="makanan & minuman" <?= old('jenis_booth', $booth['jenis_booth']) == 'makanan & minuman' ? 'selected' : '' ?>>Makanan dan Minuman</option>
                <option value="komunitas" <?= old('jenis_booth', $booth['jenis_booth']) == 'komunitas' ? 'selected' : '' ?>>Komunitas</option>
                <option value="merchandise" <?= old('jenis_booth', $booth['jenis_booth']) == 'merchandise' ? 'selected' : '' ?>>Merchandise</option>
                <option value="lainnya" <?= old('jenis_booth', $booth['jenis_booth']) == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
            <?php if (session('validation') && session('validation')->hasError('jenis_booth')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('jenis_booth'); ?>
                </p>
            <?php endif; ?>
        </div>

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

        <div class="md:col-span-2 flex justify-end">
            <button type="submit" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Ubah Booth
            </button>
        </div>

    </form>
</section>
<?= $this->endSection() ?>