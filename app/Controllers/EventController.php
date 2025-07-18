<?php

namespace App\Controllers;

use App\Models\BoothListModel;
use App\Models\EventModel;

use function PHPUnit\Framework\fileExists;

class EventController extends BaseController
{
    protected $eventModel;
    protected $boothListModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->boothListModel = new BoothListModel(); 
    }

    public function index()
    {
        // ambil semua data event dari model
        $data = [
            'events' => $this->eventModel->getEvent(),
        ];

        return view('layout/header', ['title' => 'Jvent'])
            . view('event/index', $data)
            . view('layout/footer');
    }

    public function filter($kategori_tiket = null, $sort = null)
    {
        // ambil keyword dari input pencarian
        $keyword = $this->request->getVar('keyword');
        // query builder untuk model event
        $query = $this->eventModel;

        // filter berdasarkan keyword
        if ($keyword) {
            // escape keyword untuk menghindari SQL injection
            $keyword = trim($keyword);
            // groupStart untuk menggabungkan kondisi LIKE dengan OR
            $query = $query->groupStart()
                        ->like('judul_event', $keyword)
                        ->orLike('lokasi_event', $keyword)
                        ->orLike('organizer', $keyword)
                        ->orLike('kategori_tiket', $keyword)
                        ->groupEnd();
        }

        // filter berdasarkan kategori tiket
        if ($kategori_tiket && $kategori_tiket !== 'all') {
            $query = $query->where('kategori_tiket', $kategori_tiket);
        }

        // urutkan event berdasarkan tanggal terbaru atau terlama
        if ($sort && $sort === 'terbaru') {
            $query = $query->orderBy('tanggal_event', 'DESC');
        } elseif ($sort && $sort === 'terlama') {
            $query = $query->orderBy('tanggal_event', 'ASC');
        }

        // ambil data event sesuai dengan filter dan pagination
        $data = [
            'events' => $query->paginate(8, 'event_table'),
            'pager' => $this->eventModel->pager,
        ];

        return view('layout/header', ['title' => 'Filter Event', 'keyword' => $keyword])
            . view('event/filter', $data)
            . view('layout/footer');
    }

    public function create () {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Form Tambah Data Event',
            'validation' => \Config\Services::validation(),
        ];

        return view('event/create', $data);
    }

    public function save () {
        // cek apakah admin sudah login
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ambil input dari form untuk kategori tiket dan harga tiket
        $kategori_tiket = $this->request->getVar('kategori_tiket');
        $harga_input = $this->request->getPost('harga_tiket');

        // validasi input untuk tiap field pada form tambah event
        // rules untuk validasi input
        $rules = [
            'judul_event' => [
                'rules' => 'required|is_unique[event_table.judul_event]',
                'errors' => [
                    'required' => 'Judul event harus diisi',
                    'is_unique' => 'Event sudah terdaftar',
                ]
            ],
            'organizer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama penyelenggara harus diisi'
                ]
            ],
            'gambar_event' => [ // validasi gambar
                'rules' => 'uploaded[gambar_event]|max_size[gambar_event,500]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar event terlebih dahulu.',
                    'max_size' => 'Ukuran gambar terlalu besar (maks 500KB).',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
                ]
            ],
            'tanggal_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal event harus diisi',
                ]
            ],
            'lokasi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'lokasi event harus diisi',
                ]
            ],
            'kategori_tiket' => [
                'rules' => 'required|in_list[gratis,berbayar]',
                'errors' => [
                    'required' => 'kategori tiket harus diisi',
                ]
            ],
            'link_tiket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'link tiket harus diisi',
                ]
            ],
            'deskripsi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'deskripsi event harus diisi',
                ]
            ]
        ];

        // validasi harga tiket jika kategori tiket berbayar
        // jika kategori tiket adalah berbayar, maka harga tiket harus diisi
        if ($kategori_tiket === 'berbayar') {
            $rules['harga_tiket'] = 'required|numeric';
        }
        
        // validasi input
        if (!$this->validate($rules)) { 
            // pesan kesalahan disimpan 
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }        

        // bersihkan input harga tiket dari titik ribuan
        // jika kategori tiket adalah gratis, maka harga tiket di-set ke 0
        $harga_bersih = str_replace('.', '', $harga_input); // hilangkan titik ribuan
        $harga_tiket = ($kategori_tiket === 'gratis') ? 0 : (int) $harga_bersih;
        
        // ambil file gambar dari input
        $fileGambar = $this->request->getFile('gambar_event');
        
        // simpan gambar ke folder
        $namaGambar = $fileGambar->getRandomName(); // Buat nama random untuk gambar
        
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', $fileGambar->getErrorString());
        }
        $fileGambar->move(FCPATH . 'uploads/images', $namaGambar);

        // slug dari input judul event 
        $slug = url_title($this->request->getVar('judul_event'), '-', true);

        // data diambil per key dan dikirim ke model
        $this->eventModel->save([
            'judul_event' => $this->request->getVar('judul_event'),
            'gambar_event' => $namaGambar,
            'organizer' => $this->request->getVar('organizer'),
            'slug' => $slug,
            'tanggal_event' => $this->request->getVar('tanggal_event'),
            'lokasi_event' => $this->request->getVar('lokasi_event'),
            'kategori_tiket' => $kategori_tiket,
            'harga_tiket' => $harga_tiket,
            'link_tiket' => $this->request->getVar('link_tiket'),
            'deskripsi_event' => $this->request->getVar('deskripsi_event'),
            'sponsor' => $this->request->getVar('sponsor'),
            'guest_star' => $this->request->getVar('guest_star'),
            'booth_list' => $this->request->getVar('booth_list'),
            'id_admin' => $session->get('id_admin'),
        ]);

        // flash data
        $session->setFlashdata('pesan', 'Event berhasil ditambahkan...');

        return redirect()->to('/dashboard');
    }

    public function detail($slug)
    {
        // ambil daftar booth yang tersedia di event
        $boothList = $this->boothListModel->findAll();
        
        // cek apakah event dengan slug tersebut ada
        if (!$this->eventModel->getEvent($slug)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Event ' . $slug . ' tidak ditemukan');
        }

        // ambil daftar booth yang terkait dengan event dicari
        // filter booth berdasarkan id_event yang sesuai dengan slug
        $boothList = array_filter($boothList, function($booth) use ($slug) {
            return $booth['id_event'] === $this->eventModel->getEvent($slug)['id_event'];
        });

        // ambil data event berdasarkan slug
        $events = $this->eventModel->getEvent($slug);

        // simpan data event dan booth ke dalam array
        $data = [
            'events' => $events,
            'booths' => $boothList,
        ];

        // cek jika event tidak ada
        if (empty($data['events']) && empty($data['booths'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Event ' . $slug . ' tidak ditemukan');
        } 

        // tampilkan view detail event
        return view('layout/header', ['title' => $slug])
        . view('event/detail', $data)
        . view('layout/footer');
    }

    public function delete ($id) {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // ambil data event berdasarkan id
        $event = $this->eventModel->find($id);
        
        // cek apakah event tersebut ada, jika tidak ada, tampilkan error
        if (!$event) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event tidak ditemukan');
        }

        // hapus gambar event jika ada
        if (!empty($event['gambar_event']) && file_exists(FCPATH . 'uploads/images/' . $event['gambar_event'])) {
            unlink(FCPATH . 'uploads/images/' . $event['gambar_event']);
        }

        // hapus event dari database berdasarkan id
        $this->eventModel->delete($id);

        // flash data
        session()->setFlashdata('pesan', 'Event berhasil dihapus');
        
        return redirect()->to('/dashboard');
    }

    public function edit ($slug) {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // ambil data event berdasarkan slug
        $data = [
            'title' => 'Ubah Event ' . $slug,
            'validation' => \Config\Services::validation(),
            'events' => $this->eventModel->getEvent($slug),
        ];

        // cek apakah event dengan slug tersebut ada
        if (!$data['events']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Event dengan slug ' . $slug . ' tidak ditemukan');
        }

        // jika ada tampilkan view untuk mengedit event
        return view('event/edit', $data)
        . view('layout/footer');
    }

    public function update ($id) {
        // cek apakah admin sudah login dengan session
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ambil kategori tiket dan harga tiket dari input
        $kategori_tiket = $this->request->getPost('kategori_tiket');
        $harga_input = $this->request->getPost('harga_tiket');

        // rules untuk validasi input pada tiap field pada form edit event
        $rules= [
            'judul_event' => [
                'rules' => 'required|is_unique[event_table.judul_event, id_event, ' . $id . ']',
                'errors' => [
                    'required' => 'Judul event harus diisi',
                    'is_unique' => 'Event sudah terdaftar',
                ]
            ],
            'organizer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama penyelenggara harus diisi'
                ]
            ],
            'gambar_event' => [
                'rules' => 'permit_empty|max_size[gambar_event,500]|is_image[gambar_event]|mime_in[gambar_event,image/jpg,image/jpeg,image/png]', // Tambahkan permit_empty
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maks 500KB).',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
                ]
            ],
            'tanggal_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal event harus diisi',
                ]
            ],
            'lokasi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'lokasi event harus diisi',
                ]
            ],
            'kategori_tiket' => [
                'rules' => 'required|in_list[gratis,berbayar]',
                'errors' => [
                    'required' => 'kategori tiket harus diisi',
                ]
            ],
            'link_tiket' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'link tiket harus diisi',
                ]
            ],
            'deskripsi_event' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'deskripsi event harus diisi',
                ]
            ]
        ];

        // validasi tiket jika kategori tiket berbayar
        // jika kategori tiket adalah berbayar, maka harga tiket harus diisi
        if ($kategori_tiket === 'berbayar') {
            $rules['harga_tiket'] = 'required|numeric';
        }

        // validasi input
        if (!$this->validate($rules)) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->to('/event/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        // bersihkan input harga tiket dari titik ribuan
        // jika kategori tiket adalah gratis, maka harga tiket di-set ke 0
        $harga_bersih = str_replace('.', '', $harga_input); // hilangkan titik ribuan
        $harga_tiket = ($kategori_tiket === 'gratis') ? 0 : (int) $harga_bersih;

        // ambil file gambar dari input
        $fileGambar = $this->request->getFile('gambar_event');
        $namaGambar = $this->request->getVar('gambar_lama');

        // jika ada gambar baru di-upload
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $namaGambarBaru = $fileGambar->getRandomName();
            $fileGambar->move(FCPATH . 'uploads/images', $namaGambarBaru);

            // Hapus gambar lama jika ada
            $gambarLama = $this->request->getVar('gambar_lama');
            if (!empty($gambarLama) && file_exists(FCPATH . 'uploads/images/' . $gambarLama)) {
                unlink(FCPATH . 'uploads/images/' . $gambarLama);
            }

            // Ganti nama gambar ke yang baru
            $namaGambar = $namaGambarBaru;
        }

        // slug dari input judul event 
        $slug = url_title($this->request->getVar('judul_event'), '-', true);

        // data diambil per key dan dikirim ke model
        $this->eventModel->save([
            'id_event' => $id,
            'judul_event' => $this->request->getVar('judul_event'),
            'gambar_event' => $namaGambar,
            'slug' => $slug,
            'organizer' => $this->request->getVar('organizer'),
            'tanggal_event' => $this->request->getVar('tanggal_event'),
            'lokasi_event' => $this->request->getVar('lokasi_event'),
            'harga_tiket' => $harga_tiket,
            'kategori_tiket' => $kategori_tiket,
            'link_tiket' => $this->request->getVar('link_tiket'),
            'deskripsi_event' => $this->request->getVar('deskripsi_event'),
            'sponsor' => $this->request->getVar('sponsor'),
            'guest_star' => $this->request->getVar('guest_star'),
            'booth_list' => $this->request->getVar('booth_list'),
            'id_admin' => $session->get('id_admin'),
        ]);

        // flash data
        $session->setFlashdata('pesan', 'Event berhasil diubah...');

        return redirect()->to('/dashboard');
    }
}
