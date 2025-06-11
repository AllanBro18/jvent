<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="rounded-lg p-6 shadow-md">
    <div class="flex md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-white mb-4 md:mb-0">Booth Management Panel</h2>
        <div class="flex items-center space-x-3">
            <!-- Select Event Dropdown (dummy for now) -->
            <select class="bg-gray-700 text-white px-3 py-2 rounded focus:outline-none">
                <option>Pilih Event</option>
                <!-- Tambahkan opsi event di sini -->
            </select>
            <a href="<?= base_url('booth/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold transition">Tambah Booth +</a>
        </div>
        
    </div>

    <!-- Pesan booths -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-600 text-white px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-600 text-white px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($booths)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-300">
            <thead>
                <tr class="bg-gray-700 text-gray-200 uppercase text-xs">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nama Booth</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($booths as $booth): ?>
                <tr class="bg-gray-900 border-b border-gray-700">
                    <td class="px-4 py-3"><?= $no++ ?></td>
                    <td class="px-4 py-3 font-semibold"><?= esc($booth['nama_booth']) ?></td>
                    <td class="px-4 py-3 font-bold">Rp<?= esc(number_format($booth['harga_sewa'], 0, ',', '.')) ?></td>
                    <td class="px-4 py-3 font-bold flex items-center space-x-2">
                        <?php
                            switch ($booth['status']) {
                                case 'tersedia':
                                    echo '<span class="text-green-400 text-lg">✔</span><span class="text-green-400">Tersedia</span>';
                                    break;
                                case 'disewa':
                                    echo '<span class="text-red-400 text-lg">✖</span><span class="text-yellow-400">Disewa</span>';
                                    break;
                                case 'tidak tersedia':
                                    echo '<span class="text-red-400 text-lg">✖</span><span class="text-red-400">Terisi</span>';
                                    break;
                                default:
                                    echo esc($booth['status']);
                            }
                        ?>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="<?= base_url('booth/' . $booth['id_event']) ?>" class="text-blue-600 hover:underline">Details</a>
                        <a href="<?= base_url('booth/edit/' . $booth['id_event']) ?>" class="text-yellow-400 hover:underline">Edit</a>
                        <form action="/booth/<?= $booth['id_booth'] ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" onclick="return confirm('Apakah anda yakin menghapus booth ini?')" class="text-red-600">
                                <p>Delete</p>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="text-gray-400 mt-8">Tidak ada booth yang tersedia untuk event ini.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>