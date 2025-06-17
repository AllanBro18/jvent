<section class="text-white min-h-screen flex flex-col items-center justify-center px-4">
    <!-- Register Form -->
    <div class="w-full max-w-md bg-transparent">
        <h2 class="text-3xl font-bold text-center mb-2">Buat akun Jvent kamu</h2>
        <p class="text-center text-sm text-gray-300 mb-6">daftar untuk membuat event</p>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4 text-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('/register') ?>" method="post" class="space-y-4">
            <input 
                type="text" 
                name="username_admin" 
                placeholder="Username" 
                class="w-full px-4 py-3 rounded-md border border-gray-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft" 
                />
            <?php if (session('validation') && session('validation')->hasError('username_admin')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('username_admin'); ?>
                </p>
            <?php endif; ?>

            <input 
                type="email" 
                name="email_admin" 
                placeholder="Email" 
                class="w-full px-4 py-3 rounded-md border border-gray-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft" 
                />
            <?php if (session('validation') && session('validation')->hasError('email_admin')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('email_admin'); ?>
                </p>
            <?php endif; ?>

            <input 
                type="password" 
                name="password_admin" 
                placeholder="Password" 
                class="w-full px-4 py-3 rounded-md border border-gray-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft" 
                />
            <?php if (session('validation') && session('validation')->hasError('password_admin')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('password_admin'); ?>
                </p>
            <?php endif; ?>

            <input 
                type="password" 
                name="password_confirm" 
                placeholder="Re-enter Password" 
                class="w-full px-4 py-3 rounded-md border border-gray-400 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft" 
                />
            <?php if (session('validation') && session('validation')->hasError('password_confirm')) : ?>
                <p class="mt-1 text-sm text-red-500">
                <?= session('validation')->getError('password_confirm'); ?>
                </p>
            <?php endif; ?>

            <button type="submit"
                class="w-full px-2 py-3 text-center bg-gradient-to-r from-tertiary-soft to-violet-600 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Register
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-300">
            Punya Akun? <a href="<?= base_url('/login') ?>" class="text-white underline">Login</a>
        </div>
    </div>

</section>