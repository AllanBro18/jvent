<section class="text-white min-h-screen p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Admin</h1>
    <p>Selamat datang, <?= session()->get('username_admin') ?>!</p>

    <a href="/logout" class="inline-block mt-4 bg-red-600 px-4 py-2 rounded hover:bg-red-700">Logout</a>

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 p-6 hidden md:block">
        <h1 class="text-3xl font-bold text-cyan-400 mb-10">Jvent</h1>
        <nav class="space-y-4 text-white text-base">
            <a href="#" class="block font-semibold">Dashboard</a>
            <a href="#" class="block text-gray-300 hover:text-white">Event Saya</a>
            <a href="#" class="block text-gray-300 hover:text-white">Informasi Dasar</a>
            <a href="#" class="block text-gray-300 hover:text-white">Pengaturan</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl sm:text-2xl font-semibold">Event Saya</h2>
        <div class="flex items-center gap-3">
            <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Buat Event</button>
            <div class="bg-gray-700 px-3 py-2 rounded text-sm">Event Organizer</div>
        </div>
        </div>

        <!-- Search and Sort -->
        <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-4 mb-8">
            <div class="w-full sm:w-1/2 relative">
                <input
                type="text"
                placeholder="Cari event disini"
                class="w-full py-2 pl-10 pr-4 rounded bg-gray-700 placeholder-gray-300 text-white focus:outline-none"
                >
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 16.65z" />
                </svg>
            </div>
            <div>
                <label class="mr-2 text-sm text-gray-300">Urutkan:</label>
                <select class="bg-purple-600 text-white py-2 px-4 rounded text-sm">
                    <option>Waktu Mulai (Terdekat)</option>
                    <option>Nama Event (A-Z)</option>
                    <option>Terbaru</option>
                </select>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-6 mb-6 border-b border-gray-700 text-sm sm:text-base">
            <button class="border-b-2 border-white pb-2 font-semibold">EVENT AKTIF</button>
            <button class="text-gray-400 pb-2 hover:text-white">EVENT LALU</button>
        </div>

        <!-- Event Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition">
                <img src="https://source.unsplash.com/600x400/?concert,party" alt="Event" class="w-full h-40 object-cover">
                <div class="p-4 space-y-2">
                    <h3 class="text-lg font-semibold">World Music Festival</h3>
                    <div class="text-sm text-gray-300 flex items-center gap-2">
                    📅 25–27 July, 2025 &bull; 📍Valencia, ES
                    </div>
                    <p class="text-sm font-bold text-white">
                    <?= $i === 0 ? 'Rp.100.000' : 'Gratis' ?>
                    </p>
                    <div class="flex items-center gap-2 mt-3">
                    <img src="https://i.pravatar.cc/30" class="rounded-full w-7 h-7" alt="User">
                    <span class="text-sm text-gray-300">Imagi</span>
                    </div>
                </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Footer Text -->
        <div class="mt-10 text-center space-y-3">
            <button class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded font-semibold">Buat Event</button>
            <p class="text-lg font-semibold">Hai, terima kasih telah menggunakan Jvent</p>
            <p class="text-sm text-gray-400">Silahkan Buat Event Mu dengan klik Button Diatas!</p>
        </div>
    </main>

</section>