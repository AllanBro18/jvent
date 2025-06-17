fetch('api/events')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('event-list');
        // Buat section hero dan judul hanya sekali
        container.innerHTML = `
            <div class="w-full h-auto relative bg-cover bg-center rounded-md" style="background-image: url('assets/images/hero.jpg')">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="py-10 ml-24 w-72 relative z-10 text-white">
                    <h1 class="py-2 text-3xl font-bold">Temukan Event Anime Terdekat di Banjarmasin</h1>
                    <p class="py-2 font-thin">Platform event anime terbaik di Banjarmasin. Temukan dan ikuti event seru di Banjarmasin.</p>
                    <a href="/event/search" class="px-4 py-2 text-center bg-gradient-to-r from-tertiary-hard to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition">
                        Jelajahi Event Sekarang
                    </a>
                </div>
            </div>
            <div class="my-10 min-h-screen">
                <h1 class="text-center text-2xl font-bold text-white">Event Populer</h1>
                <div class="mt-5 px-10">
                    <div id="event-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"></div>
                </div>
            </div>
        `;
        const grid = container.querySelector('#event-grid');
        data.forEach(event => {
            const div = document.createElement('div');
            div.className = "bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden";
            div.innerHTML = `
                <a href="/events/${event.slug}" target="_blank">
                    <img class="w-full h-48 object-cover" src="${event.gambar_event ? '/uploads/images/' + event.gambar_event : '/assets/images/hero.jpg'}" alt="Event Image" />
                </a>
                <div class="p-5">
                    <a href="/events/${event.slug}" target="_blank">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">${event.judul_event}</h5>
                    </a>
                    <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📍${event.lokasi_event || '-'}</p>
                    <p class="mb-1 text-sm text-gray-700 dark:text-gray-400">📅${event.tanggal_event || '-'}</p>
                    ${event.harga_tiket == 0 ? 
                        `<p class="mb-3 text-lg font-bold text-green-400">🏷️Gratis</p>` : 
                        `<p class="mb-3 text-lg font-bold text-gray-900 dark:text-white">🏷️Rp${event.harga_tiket ? event.harga_tiket.toLocaleString('id-ID') : '-'}</p>`
                    }
                    <div class="flex items-center border-t pt-3 border-secondary-main">
                        <img class="w-10 h-10 rounded-full shadow mr-3" src="${event.gambar_event ? '/uploads/images/' + event.gambar_event : '/assets/images/hero.jpg'}" alt="Organizer" />
                        <p class="text-sm text-gray-700 dark:text-gray-400">${event.organizer || '-'}</p>
                    </div>
                </div>
            `;
            grid.appendChild(div);
        });
    });
