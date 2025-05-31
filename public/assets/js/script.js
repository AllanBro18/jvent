const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');

hamburger.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
});

// form event
function toggleHargaTiket() {
  const kategori = document.getElementById("kategori_tiket").value;
  const hargaWrapper = document.getElementById("harga_tiket_wrapper");

  if (kategori === "berbayar") {
      hargaWrapper.style.display = "block";
  } else {
      hargaWrapper.style.display = "none";
  }
}