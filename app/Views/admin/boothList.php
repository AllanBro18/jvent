<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="rounded-lg p-6 shadow-md">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white mb-4">Booth Management Panel</h2>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Form Filter Event -->
            <form method="get" action="<?= base_url('dashboard/boothlist') ?>" 
                  class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full md:w-auto">
                <label for="id_event" class="text-gray-300 font-medium">Pilih Event:</label>
                <select id="id_event" name="id_event"
                    class="bg-gray-800 border border-gray-600 text-white px-3 py-2 rounded w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    onchange="this.form.submit()">
                    <option value="">Pilih Event</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event['id_event'] ?>" <?= (isset($selected_id_event) && $selected_id_event == $event['id_event']) ? 'selected' : '' ?>>
                            <?= esc($event['judul_event']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Tombol Tambah -->
            <div class="w-full sm:w-auto">
                <a href="<?= base_url('boothlist/create') ?>"
                   class="block text-center bg-gradient-to-r from-blue-600 to-tertiary-hard hover:from-blue-700 hover:to-purple-700 text-white px-5 py-2 rounded font-semibold shadow transition w-full sm:w-auto">
                    Tambah Booth +
                </a>
            </div>
        </div>
    </div>

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
    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-300 border-collapse">
            <thead>
                <tr class="bg-gray-700 text-gray-200 uppercase text-xs">
                    <th class="px-2 py-2 md:px-4 md:py-3">#</th>
                    <th class="px-2 py-2 md:px-4 md:py-3">Nama Booth</th>
                    <th class="px-2 py-2 md:px-4 md:py-3">Harga</th>
                    <th class="px-2 py-2 md:px-4 md:py-3">Status</th>
                    <th class="px-2 py-2 md:px-4 md:py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($booths as $booth): ?>
                <tr class="bg-gray-900 border-b border-gray-700">
                    <td class="px-2 py-2 md:px-4 md:py-3"><?= $no++ ?></td>
                    <td class="px-2 py-2 md:px-4 md:py-3 font-semibold"><?= esc($booth['nama_booth']) ?></td>
                    <td class="px-2 py-2 md:px-4 md:py-3 font-bold">Rp<?= esc(number_format($booth['harga_sewa'], 0, ',', '.')) ?></td>
                    <td class="px-2 py-2 md:px-4 md:py-3 font-bold flex items-center space-x-2">
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
                    <td class="px-2 py-2 md:px-4 md:py-3 space-x-2">
                        <div class="flex flex-col md:flex-row items-start md:items-end">
                            <a href="<?= base_url('boothlist/edit/' . $booth['id_booth']) ?>" class="my-1 md:mx-1 bg-gradient-to-r from-tertiary-hard to-blue-600 hover:opacity-90 text-white px-3 py-1 rounded hover:bg-purple-700 transition">Edit</a>
                            <form action="/boothlist/<?= $booth['id_booth'] ?>" method="post" class="my-1 md:mx-1">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" onclick="return confirm('Apakah anda yakin menghapus booth ini?')" class="bg-red-600 px-2 py-1 rounded hover:bg-red-700 text-white">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <p class="text-gray-400">Tidak ada booth yang tersedia untuk event ini.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
