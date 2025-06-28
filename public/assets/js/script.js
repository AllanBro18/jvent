// hamburger menu pada header
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');

hamburger.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
});

// form event dropdown harga tiket (berbayar/gratis)
function toggleHargaTiket() {
  const kategori = document.getElementById("kategori_tiket").value;
  const hargaWrapper = document.getElementById("harga_tiket_wrapper");

  if (kategori === "berbayar") {
    hargaWrapper.style.display = "block";
  } else {
    hargaWrapper.style.display = "none";
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const toast = document.getElementById('notFoundToast');
  if (toast) {
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
  }
});

// MODAL untuk Produk Booth
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
  formMethod.value = "POST"; // CodeIgniter 4 menangani PUT/PATCH melalui POST dengan _method
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
                <img src="<?= base_url('uploads/produk/') ?>/${produkData.gambar_produk}" alt="${produkData.nama_produk}" class="w-24 h-24 object-cover rounded">
            `;
  }

  modal.classList.remove('hidden');
}

// Menutup modal jika klik di luar area modal
window.onclick = function (event) {
  if (event.target == modal) {
    closeModal();
  }
}