<section class="text-white min-h-screen">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="md:w-1/5 w-full md:h-screen bg-secondary-main hidden md:block text-center">
            <h2 class="font-bold text-3xl bg-gray-700 text-secondary-second pb-2">
                Jvent
            </h2>

            <!-- Wrapper Dropdown -->
            <div class="relative mt-5">
                <nav class="space-y-4 text-white text-base">
                    <a href="/dashboard" class="block font-semibold">Dashboard</a>
                    <a href="/dashboard/event" class="block text-gray-300 hover:text-white">Event Saya</a>
                    <a href="/dashboard/info" class="block text-gray-300 hover:text-white">Informasi Dasar</a>
                    <a href="/dashboard/pengaturan" class="block text-gray-300 hover:text-white">Pengaturan</a>
                </nav>
            </div>

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
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                    <a href="/event/<?= "Test" ?>" target="_blank">
                        <img class="w-full h-48 object-cover" src="/assets/images/hero.jpg" alt="Event Image" />
                    </a>
                    <div class="p-5">
                        <a href="/event/<?= "Test" ?>" target="_blank">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"> <?= "Test" ?> </h5>
                        </a>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= "Test" ?></p>
                        <p class="mb-1 text-sm text-gray-700 dark:text-gray-400"><?= "Test" ?></p>
                        <p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">Rp<?= "Test" ?></p>
                        <div class="flex items-center border-t pt-3 border-secondary-main">
                            <img class="w-10 h-10 rounded-full shadow mr-3" src="/assets/images/hero.jpg" alt="Organizer" />
                            <p class="text-sm text-gray-700 dark:text-gray-400">Imagi</p>
                        </div>
                    </div>
                </div>
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition">
                        <img src="/assets/images/hero.jpg" alt="Event" class="w-full h-40 object-cover">
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
    </div>
</section>