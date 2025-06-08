<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
    <!-- Header -->
    <header class="bg-gradient-to-br from-secondary-main via-primary to-secondary-main px-4 md:px-8 py-4 flex flex-col md:flex-row md:justify-between md:items-center space-y-3 md:space-y-0 shadow-md backdrop-blur-md">
        <!-- Logo + Searchbar Grid on Mobile -->
        <div class="w-full grid grid-cols-1 gap-3 md:flex md:items-center md:w-auto md:gap-0 md:space-x-6">
            <!-- Logo -->
            <div class="text-3xl font-bold text-secondary-second text-center md:text-left tracking-tight hover:scale-105 transition-transform duration-200">
                <a href="/" class="hover:text-white">Jvent</a>
            </div>

            <!-- Search bar -->
            <form action="" method="post">
                <div class="flex items-center bg-white/20 backdrop-blur-md px-3 py-2 rounded-lg w-full md:w-[400px] border border-white/30 shadow-inner focus-within:ring-2 focus-within:ring-secondary-second transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/80 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                    <input type="text" placeholder="Cari event disini" name="keyword"
                        class="bg-transparent outline-none w-full text-sm text-white placeholder-white/70">
                </div>
            </form>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="/event/create"
                class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Buat Event</span>
            </a>
            <a href="/event/search"
            class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Jelajah</span>
            </a>
            <?php
            $session = session();
            if ($session->has('logged_in')) : ?>
                <a href="/dashboard"
                class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary-second" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= session('username_admin') ?></span>
                </a>
            <?php else : ?>
                <a href="/login" class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary-second" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H3m0 0l4-4m-4 4l4 4m13-8v8a2 2 0 01-2 2H9" />
                    </svg>
                    <span>Sign In</span>
                </a>
            <?php endif; ?>
        </nav>

        <!-- Hamburger -->
        <button id="hamburger" class="md:hidden absolute top-4 right-4">
            <svg class="w-6 h-6 text-secondary-second hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </header>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-gradient-to-b from-primary to-secondary-main text-white py-8 px-6">
        <div class="flex flex-col items-center space-y-4">
            <a href="/event/create"
            class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Buat Event</span>
            </a>

            <a href="/event/search"
            class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Jelajah</span>
            </a>

            <?php
            $session = session();
            if ($session->has('logged_in')) : ?>
                <a href="/dashboard"
                class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary-second" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= session('username_admin') ?></span>
                </a>
            <?php else : ?>
                <a href="/login" class="flex items-center space-x-1 text-sm text-white font-medium transition-all duration-300 px-3 py-2 rounded-lg hover:scale-105 hover:shadow-lg hover:backdrop-blur-sm bg-white/5 hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary-second" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12H3m0 0l4-4m-4 4l4 4m13-8v8a2 2 0 01-2 2H9" />
                    </svg>
                    <span>Sign In</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>