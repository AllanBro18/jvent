<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>
    <!-- Main Content -->
    <main class="flex-1 p-6 sm:p-10 space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Informasi Dasar</h2>
        </div>

        <!-- Latar Belakang -->
        <section>
            <h3 class="text-xl font-semibold mb-2 text-secondary-second">Latar Belakang</h3>
            <p class="text-gray-300 leading-relaxed">
                Minat masyarakat Indonesia terhadap budaya Jepang mengalami peningkatan yang cukup signifikan, terutama di kalangan remaja dan dewasa muda. 
                Fenomena ini terlihat dari semakin banyaknya acara bertema Jejepangan seperti festival budaya, cosplay, konser anime, hingga bazar komunitas 
                yang diadakan di berbagai kota. Meskipun jumlah event terus bertambah, masih banyak kendala yang dirasakan oleh penggemar maupun penyelenggara event.
            </p>
            <p class="text-gray-300 mt-3 leading-relaxed">
                Salah satu permasalahan yang sering muncul adalah sulitnya menemukan informasi event secara lengkap dan terpercaya. Informasi biasanya tersebar di 
                berbagai platform media sosial tanpa format yang jelas, sehingga banyak orang yang tidak mengetahui adanya event atau bahkan ketinggalan karena 
                informasi tidak sampai ke mereka tepat waktu.
            </p>
            <p class="text-gray-300 mt-3 leading-relaxed">
                Di sisi lain, penyelenggara event juga menghadapi tantangan tersendiri, khususnya dalam menjangkau calon pengunjung yang sesuai dengan target acara 
                mereka. Banyak dari mereka masih mengandalkan metode promosi manual atau media sosial yang tidak terintegrasi.
            </p>
            <p class="text-gray-300 mt-3 leading-relaxed">
                Melihat kondisi tersebut, Jvent hadir sebagai jembatan antara penyelenggara dan penggemar anime. Aplikasi Jvent dirancang untuk menjadi solusi digital 
                yang mempermudah pencarian, penjelajahan, dan pengelolaan informasi event Jejepangan, sekaligus menjadi media promosi yang efektif bagi para penyelenggara.
            </p>
        </section>

        <!-- Tujuan -->
        <section>
            <h3 class="text-xl font-semibold mb-2 text-secondary-second">Tujuan</h3>
            <ul class="list-disc list-inside text-gray-300 space-y-1">
                <li>Menyediakan platform yang mudah diakses untuk mencari informasi seputar event Jejepangan di berbagai daerah.</li>
                <li>Membantu pengguna menemukan event berdasarkan preferensi seperti lokasi, waktu, dan harga tiket.</li>
                <li>Menyediakan fitur pengingat agar pengguna tidak melewatkan event yang diminati.</li>
                <li>Memberikan kemudahan bagi penyelenggara dalam mengunggah dan mengelola informasi event mereka.</li>
                <li>Menyediakan fitur statistik kunjungan agar penyelenggara dapat melihat performa event yang mereka buat.</li>
                <li>Mendorong pertumbuhan komunitas budaya Jepang di Indonesia melalui sistem yang mudah digunakan dan dirancang sesuai kebutuhan pengguna.</li>
            </ul>
        </section>

        <!-- Ruang Lingkup -->
        <section>
            <h3 class="text-xl font-semibold mb-2 text-secondary-second">Ruang Lingkup</h3>
            <ul class="list-disc list-inside text-gray-300 space-y-1">
                <li>Pembuatan aplikasi berbasis web dengan fitur utama seperti pencarian event dan pembuatan event.</li>
                <li>Fitur khusus bagi penyelenggara untuk menambahkan, mengedit, dan menghapus event, serta melihat data statistik pengunjung.</li>
                <li>Sistem keamanan dan otentikasi untuk menjaga data pengguna dan penyelenggara agar tetap aman.</li>
                <li>Sasaran utama pengguna adalah dua kelompok: pengunjung event (penonton, cosplayer, penggemar anime) dan penyelenggara event (komunitas atau pihak penyelenggara acara).</li>
            </ul>
            <p class="text-gray-300 mt-3">
                Dengan cakupan ini, diharapkan Jvent mampu menjadi platform yang bermanfaat bagi seluruh ekosistem event Jejepangan di Indonesia.
            </p>
        </section>
    </main>

<?= $this->endSection() ?>