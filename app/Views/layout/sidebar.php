<section class="text-white font-inter min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 p-6 hidden md:block">
        <h1 class="text-3xl font-bold text-cyan-400 mb-10">
            <a href="/">Jvent</a>
        </h1>
        <nav class="space-y-4 text-white text-base">
            <a href="/dashboard" class="block text-gray-300 hover:text-white">Dashboard</a>
            <a href="/dashboard" class="block text-gray-300 hover:text-white">Event Saya</a>
            <a href="/dashboard/boothlist" class="block text-gray-300 hover:text-white">Manajemen Booth</a>
            <a href="/dashboard/info" class="block text-gray-300 hover:text-white">Informasi Dasar</a>
            <a href="/dashboard/pengaturan" class="block text-gray-300 hover:text-white">Pengaturan</a>
        </nav>
    </aside>
    <?= $this->renderSection('content'); ?>
</section>