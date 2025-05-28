<section class="text-white min-h-screen flex items-center justify-center px-4 sm:px-6">
    <div class="w-full max-w-md space-y-6">
    
        <!-- Login Title -->
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-center mb-2">Login ke Jvent</h2>
            <p class="text-center text-sm text-gray-300">masuk untuk melanjutkan</p>
        </div>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-500 text-white px-4 py-2 rounded text-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= base_url('/auth/login') ?>" method="post" class="space-y-4" autocomplete="off">
            <input
                type="text"
                name="username"
                placeholder="Username"
                required
                class="w-full px-4 py-3 rounded-md border border-gray-500 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft">
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                class="w-full px-4 py-3 rounded-md border border-gray-500 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft">
            <button
                type="submit"
                class="w-full px-2 py-3 text-center bg-gradient-to-r from-tertiary-soft to-violet-600 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="text-center text-sm text-gray-300">
            Belum punya akun?
            <a href="<?= base_url('/register') ?>" class="text-white underline">Daftar</a>
        </p>
    </div>

</section>