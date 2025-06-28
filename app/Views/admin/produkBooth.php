<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="p-4 sm:ml-64">
  <div class="flex flex-col md:flex-row text-white min-h-screen">
    <div class="rounded-lg p-6 shadow-md">
      <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Produk Booth Management Panel</h2>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <!-- Form Filter Booth -->
          <form method="get" action="<?= base_url('dashboard/produkbooth') ?>"
            class="flex flex-col sm:flex-row items-start sm:items-center gap-2 w-full md:w-auto">
            <label for="id_booth" class="text-gray-300 font-medium">Pilih Booth:</label>
            <select id="id_booth" name="id_booth"
              class="bg-gray-800 border border-gray-600 text-white px-3 py-2 rounded w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
              onchange="this.form.submit()">
              <option value="">Pilih Booth</option>
              <?php foreach ($booths as $booth): ?>
                <option value="<?= $booth['id_booth'] ?>" <?= (isset($selected_id_booth) && $selected_id_booth == $booth['id_booth']) ? 'selected' : '' ?>>
                  <?= esc($booth['nama_booth']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>

          <!-- Tombol Tambah (Trigger Modal) -->
          <div class="w-full sm:w-auto">
            <button type="button"
              onclick="openCreateModal()"
              class="block text-center bg-gradient-to-r from-blue-600 to-tertiary-hard hover:from-blue-700 hover:to-purple-700 text-white px-5 py-2 rounded font-semibold shadow transition w-full sm:w-auto">
              Tambah Produk +
            </button>
          </div>

          <!-- Modal Tambah Produk -->
          <div id="produkModal" class="flex hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-6 relative">
              <button type="button" onclick="closeModal()" class="absolute top-2 right-2 text-gray-400 hover:text-white text-xl">&times;</button>

              <h3 id="modalTitle" class="text-xl font-bold mb-4 text-white">Tambah Produk</h3>

              <form id="produkForm" action="<?= base_url('/produkbooth/save') ?>" method="post" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
                <?= csrf_field() ?>
                <input type="hidden" name="id_produk" id="id_produk">
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="mb-4">
                  <label for="id_booth_modal" class="block mb-2 text-white text-sm font-medium">Pilih Booth</label>
                  <select id="id_booth_modal" name="id_booth" class="w-full bg-secondary-main text-white py-2 px-4 rounded text-sm">
                    <option value="">-- Pilih Booth --</option>
                    <?php foreach ($booths as $booth): ?>
                      <option value="<?= $booth['id_booth']; ?>">
                        <?= esc($booth['nama_booth']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-4">
                  <label for="nama_produk" class="block mb-2 text-sm font-normal text-gray-300">Nama Produk</label>
                  <input type="text" name="nama_produk" id="nama_produk" required class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                  <label for="gambar_produk" class="block mb-2 text-sm font-normal text-gray-300">Gambar</label>
                  <input type="file" id="gambar_produk" name="gambar_produk" class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
                  <div id="imagePreview" class="mt-2"></div>
                </div>

                <div class="mb-4">
                  <label for="harga" class="block mb-2 text-sm font-normal text-gray-300">Harga</label>
                  <input type="number" name="harga" id="harga" required class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                  <label for="status" class="block mb-2 text-sm font-normal text-gray-300">Status</label>
                  <select name="status" id="status" required class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                    <option value="preorder">Pre-order</option>
                  </select>
                </div>
                <div class="mb-4">
                  <label for="stok" class="block mb-2 text-sm font-normal text-gray-300">Stok</label>
                  <input type="number" name="stok" id="stok" required class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                  <label for="deskripsi" class="block mb-2 text-sm font-normal text-gray-300">Deskripsi</label>
                  <textarea name="deskripsi" id="deskripsi" rows="2" class="w-full px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="col-span-2 flex justify-end">
                  <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 rounded bg-gray-700 text-gray-300 hover:bg-gray-600">Batal</button>
                  <button id="submitButton" type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                </div>
              </form>
            </div>
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

      <?php if (!empty($produk)): ?>
        <div class="overflow-x-auto w-full">
          <table class="min-w-full text-sm text-left text-gray-300 border-collapse">
            <thead>
              <tr class="bg-gray-700 text-gray-200 uppercase text-xs">
                <th class="px-2 py-2 md:px-4 md:py-3">#</th>
                <th class="px-2 py-2 md:px-4 md:py-3">Nama Produk</th>
                <th class="px-2 py-2 md:px-4 md:py-3">Harga</th>
                <th class="px-2 py-2 md:px-4 md:py-3">Status</th>
                <th class="px-2 py-2 md:px-4 md:py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($produk as $p): ?>
                <tr class="bg-gray-900 border-b border-gray-700">
                  <td class="px-2 py-2 md:px-4 md:py-3"><?= $no++ ?></td>
                  <td class="px-2 py-2 md:px-4 md:py-3 font-semibold"><?= esc($p['nama_produk']) ?></td>
                  <td class="px-2 py-2 md:px-4 md:py-3 font-bold">Rp<?= esc(number_format($p['harga'], 0, ',', '.')) ?></td>
                  <td class="px-2 py-2 md:px-4 md:py-3 font-bold flex items-center space-x-2">
                    <?php
                    switch ($p['status']) {
                      case 'tersedia':
                        echo '<span class="text-green-400 text-lg">✔</span><span class="text-green-400">Tersedia</span>';
                        break;
                      case 'habis':
                        echo '<span class="text-red-400 text-lg">✖</span><span class="text-yellow-400">Disewa</span>';
                        break;
                      case 'pre-order':
                        echo '<span class="text-yellow-400 text-lg">✖</span><span class="text-red-400">Terisi</span>';
                        break;
                      default:
                        echo esc($p['status']);
                    }
                    ?>
                  </td>

                  <td class="px-2 py-2 md:px-4 md:py-3 space-x-2">
                    <div class="flex flex-col md:flex-row items-start md:items-end">
                      <button type="button"
                        data-produk='<?= json_encode($p) ?>'
                        onclick="openEditModal(this)"
                        class="my-1 md:mx-1 bg-gradient-to-r from-tertiary-hard to-blue-600 hover:opacity-90 text-white px-3 py-1 rounded hover:bg-purple-700 transition">
                        Edit
                      </button>
                      <form action="/produkbooth/<?= $p['id_produk'] ?>" method="post" class="my-1 md:mx-1">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" onclick="return confirm('Apakah anda yakin menghapus produk ini?')" class="bg-red-600 px-2 py-1 rounded hover:bg-red-700 text-white">
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
          <p class="text-gray-400">Tidak ada booth yang tersedia untuk booth ini.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script>
  // Ambil elemen-elemen modal
  const modal = document.getElementById('produkModal');
  const modalTitle = document.getElementById('modalTitle');
  const produkForm = document.getElementById('produkForm');
  const formMethod = document.getElementById('formMethod');
  const submitButton = document.getElementById('submitButton');
  const imagePreview = document.getElementById('imagePreview');

  function closeModal() {
    modal.classList.add('hidden');
    produkForm.reset(); // Bersihkan form saat ditutup
    imagePreview.innerHTML = ''; // Bersihkan preview gambar
  }

  // Fungsi untuk membuka modal dalam mode CREATE
  function openCreateModal() {
    produkForm.reset();
    produkForm.action = "<?= base_url('/produkbooth/save') ?>";
    formMethod.value = "POST";
    modalTitle.textContent = "Tambah Produk Baru";
    submitButton.textContent = "Simpan";
    document.getElementById('id_produk').value = ''; // Pastikan ID kosong
    imagePreview.innerHTML = '';

    modal.classList.remove('hidden');
  }

  // Fungsi untuk membuka modal dalam mode UPDATE
  function openEditModal(button) {
    // Ambil data dari atribut data-produk dan parse sebagai JSON
    const produkData = JSON.parse(button.getAttribute('data-produk'));

    produkForm.reset();
    produkForm.action = `<?= base_url('/produkbooth/update') ?>/${produkData.id_produk}`;
    formMethod.value = "PUT"; // CodeIgniter 4 menangani PUT/PATCH melalui POST dengan _method
    modalTitle.textContent = "Edit Produk";
    submitButton.textContent = "Update";

    // Isi form dengan data yang ada
    document.getElementById('id_produk').value = produkData.id_produk;
    document.getElementById('id_booth_modal').value = produkData.id_booth;
    document.getElementById('nama_produk').value = produkData.nama_produk;
    document.getElementById('harga').value = produkData.harga;
    document.getElementById('status').value = produkData.status;
    document.getElementById('stok').value = produkData.stok;
    document.getElementById('deskripsi').value = produkData.deskripsi;

    // Tampilkan preview gambar jika ada
    imagePreview.innerHTML = '';
    if (produkData.gambar_produk) {
      imagePreview.innerHTML = `
            <p class="text-xs text-gray-300 mb-1">Gambar saat ini:</p>
            <img src="<?= base_url('uploads/produk/') ?>/${produkData.gambar_produk}" alt="${produkData.nama_produk}" class="w-20 h-20 object-cover rounded">
        `;
    }

    modal.classList.remove('hidden');
  }

  // Menutup modal jika klik di luar area modal
  window.onclick = function(event) {
    if (event.target == modal) {
      closeModal();
    }
  }
</script>

<?= $this->endSection() ?>