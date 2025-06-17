<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
<div class="p-4 sm:ml-64">
    <div class="flex flex-col md:flex-row text-white min-h-screen">
        <!-- Main Content -->
        <main class="flex-1 p-6 sm:p-10">
          <h2 class="text-2xl font-bold mb-6">Pengaturan Akun</h2>

          <!-- Pengaturan Profil -->
          <div class="bg-gray-800 p-6 rounded-2xl shadow mb-8">
            <h3 class="text-xl font-semibold mb-4">Profil</h3>
            <form action="<?= base_url('/admin/update/' . $id_admin) ?>" method="post" class="space-y-4">
              <?= csrf_field() ?>
              <div>
                <label class="block text-sm text-gray-300 mb-1">Nama Lengkap</label>
                <input type="text" value="<?= esc($username_admin) ?>" name="username_admin" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none">
              </div>
              <div>
                <label class="block text-sm text-gray-300 mb-1">Email</label>
                <input type="text" value="<?= esc($email_admin) ?>" name="email_admin" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none">
              </div>
              <div>
                <label class="block text-sm text-gray-300 mb-1">Kata Sandi Baru</label>
                <input type="password" name="password_admin" class="w-full px-4 py-2 rounded bg-gray-700 text-white focus:outline-none">
              </div>
              <button type="submit" class="bg-purple-600 hover:bg-purple-700 px-5 py-2 rounded text-sm font-semibold">
                Simpan Perubahan
              </button>
            </form>
          </div>

          <!-- Pengaturan Notifikasi -->
          <div class="bg-gray-800 p-6 rounded-2xl shadow">
            <h3 class="text-xl font-semibold mb-4">Notifikasi</h3>
            <form class="space-y-4">
              <div class="flex items-center justify-between">
                <label class="text-sm">Email Notifikasi</label>
                <input type="checkbox" class="form-checkbox text-purple-600 h-5 w-5" checked>
              </div>
              <div class="flex items-center justify-between">
                <label class="text-sm">Notifikasi Event Terbaru</label>
                <input type="checkbox" class="form-checkbox text-purple-600 h-5 w-5">
              </div>
              <div class="flex items-center justify-between">
                <label class="text-sm">Notifikasi Promo Tiket</label>
                <input type="checkbox" class="form-checkbox text-purple-600 h-5 w-5" checked>
              </div>
              <button type="submit" class="bg-purple-600 hover:bg-purple-700 px-5 py-2 rounded text-sm font-semibold">
                Simpan Pengaturan
              </button>
            </form>
          </div>
        </main>
    </div>
</div>

<?= $this->endSection() ?>