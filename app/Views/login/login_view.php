<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<section class="text-white min-h-screen flex items-center justify-center px-4 sm:px-6">
    <div class="w-full max-w-md space-y-6">
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
        <form action="<?= base_url('/login') ?>" method="post" class="space-y-4" autocomplete="off">
            <input
                type="text"
                name="username_admin"
                placeholder="Username"
                class="w-full px-4 py-3 rounded-md border border-gray-500 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft"
                value="<?= (old('username_admin') ? old('username_admin') : '') ?>">
            <?php if (session('validation') && session('validation')->hasError('username_admin')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('username_admin'); ?>
                </p>
            <?php endif; ?>

            <input
                type="password"
                name="password_admin"
                placeholder="Password"
                class="w-full px-4 py-3 rounded-md border border-gray-500 bg-transparent text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-tertiary-soft">
            <?php if (session('validation') && session('validation')->hasError('password_admin')) : ?>
                <p class="mt-1 text-sm text-red-500">
                    <?= session('validation')->getError('password_admin'); ?>
                </p>
            <?php endif; ?>

            <button
                type="submit"
                class="w-full px-2 py-3 text-center bg-gradient-to-r from-tertiary-soft to-violet-600 text-white rounded-lg font-semibold hover:opacity-90 transition">
                Login
            </button>
        </form>
    </div>

</section>
<?= $this->endSection(); ?>