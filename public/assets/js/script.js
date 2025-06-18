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