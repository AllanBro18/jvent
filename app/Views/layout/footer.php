    <footer class="bg-white text-primary pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-gray-700">
            
            <!-- Logo dan Deskripsi -->
            <div>
                <h2 class="text-xl font-bold text-primary mb-4">Jvent</h2>
                <p class="text-sm">Platform event anime terbaik di Banjarmasin. Temukan dan ikuti event seru di Banjarmasin.</p>
            </div>
            
            <!-- Link Navigasi -->
            <div>
                <h3 class="text-sm font-semibold text-primary uppercase tracking-wider mb-4">Navigasi</h3>
                <ul class="space-y-2">
                    <li><a href="/" target="_blank" class="hover:text-gray-600 transition duration-150">Beranda</a></li>
                    <li><a href="<?= base_url('/event/search') ?>" class="hover:text-gray-600 transition duration-150">Event</a></li>
                    <li><a href="/" target="_blank" class="hover:text-gray-600 transition duration-150">Tentang</a></li>
                    <li><a href="/" target="_blank" class="hover:text-gray-600 transition duration-150">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div>
                <h3 class="text-sm font-semibold text-primary uppercase tracking-wider mb-4">Layanan</h3>
                <ul class="space-y-2">
                    <li><a href="<?= base_url('/event/create') ?>" target="_blank" class="hover:text-gray-600 transition duration-150">Buat Event</a></li>
                    <li><a href="<?= base_url('/event/search') ?>" target="_blank" class="hover:text-gray-600 transition duration-150">Jelajah Event</a></li>
                </ul>
            </div>

            <!-- Sosial Media -->
            <div>
                <h3 class="text-sm font-semibold text-primary uppercase tracking-wider mb-4">Ikuti Kami</h3>
                <ul class="space-y-2">
                    <li><a href="https://www.instagram.com/nazmihakimz/" target="_blank target="_blank"" class="hover:text-gray-600 transition duration-150">Instagram</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            </div>

            <!-- Footer Bottom -->
            <div class="mt-6 py-4 text-center text-sm text-gray-500">
            &copy; 2025 Jvent. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- dropdown bekerja -->
    <script src="<?= base_url('/assets/js/script.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>