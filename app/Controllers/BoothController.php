<?php 

namespace App\Controllers;

use App\Models\BoothModel;

class BoothController extends BaseController
{
    protected $boothModel;

    public function __construct()
    {
        $this->boothModel = new BoothModel();
    }

    public function index()
    {
        $data = [
            'booths' => $this->boothModel->getBooth(),
        ];

        return 
        view('layout/header', ['title' => 'Jvent'])
        . view('booth/index', $data)
        . view('layout/footer');
    }

    public function detailBooth ($slug)
    {
        $booth = $this->boothModel->getBooth($slug);

        // Jika tidak ditemukan, lempar exception
        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        return view('layout/header', ['title' => 'Detail ' . $booth['nama_booth']])
            . view('booth/detail', ['booth' => $booth])
            . view('layout/footer');
    }

    // CRUD Booth
    public function createBooth()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }
        
        $validation = \Config\Services::validation();
        // jika ada flashdata dari validasi sebelumnya
        if (session()->getFlashdata('validation')) {
            $validation = session()->getFlashdata('validation');
        }

        return view('layout/header', ['title' => 'Buat Booth'])
            . view('booth/create', [
                'validation' => $validation,
            ])
            . view('layout/footer');
    }

    public function saveBooth()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $rules = [
            'nama_booth' => [ 
                'rules' => 'required|is_unique[booths_table.nama_booth]|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'is_unique' => 'Nama booth sudah terdaftar',
                    'min_length' => 'Nama booth minimal 3 karakter',
                    'max_length' => 'Nama booth maksimal 50 karakter',
                ] 
            ],
            'deskripsi_booth' => [ 
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => 'Deskripsi booth harus diisi',
                    'min_length' => 'Deskripsi booth minimal 10 karakter',
                    'max_length' => 'Deskripsi booth maksimal 255 karakter',
                ]
            ],
            'jenis_booth' => [ 
                'rules' => 'required|in_list[makanan & minuman,komunitas,merchandise, lainnya]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'in_list' => 'Jenis booth harus berupa makanan & minuman, komunitas, merchandise, atau lainnya',
                ] 
            ],
            'gambar_booth' => [
                'label' => 'Gambar',
                'rules' => 'uploaded[gambar_booth]|max_size[gambar_booth,500]|is_image[gambar_booth]|mime_in[gambar_booth,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar event terlebih dahulu.',
                    'max_size' => 'Ukuran gambar terlalu besar (maks 500KB).',
                    'is_image' => 'Yang Anda pilih bukan gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
                ]
            ],
            'lokasi_booth' => [
                'rules' => 'required|min_length[10]|max_length[150]',
                'errors' => [
                    'required' => 'Lokasi booth harus diisi',
                    'min_length' => 'Lokasi booth minimal 10 karakter',
                    'max_length' => 'Lokasi booth maksimal 150 karakter',
                ]
            ],
            'kontak_booth' => [
                'rules' => 'required|min_length[10]|max_length[150]',
                'errors' => [
                    'required' => 'Kontak booth harus diisi',
                    'min_length' => 'Kontak booth minimal 10 karakter',
                    'max_length' => 'Kontak booth maksimal 150 karakter',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            dd($validation->getErrors());
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // ambil file gambar
        $fileGambar = $this->request->getFile('gambar_booth');

        // Cek apakah file gambar valid
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Gambar tidak valid');
        }

        // simpan gambar ke folder uploads/images
        $namaGambar = $fileGambar->getRandomName();

        // Pindahkan file gambar ke folder uploads
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', $fileGambar->getErrorString());
        }
        $fileGambar->move(FCPATH . 'uploads/images', $namaGambar);

        $this->boothModel->save([
            'nama_booth' => $this->request->getVar('nama_booth'),
            'slug' => url_title($this->request->getVar('nama_booth'), '-', true),
            'deskripsi_booth' => $this->request->getVar('deskripsi_booth'),
            'gambar_booth' => $namaGambar,
            'jenis_booth' => $this->request->getVar('jenis_booth'),
            'lokasi_booth' => $this->request->getVar('lokasi_booth'), // Pastikan id_event ada di form
            'kontak_booth' => $this->request->getVar('kontak_booth'),
            'id_admin' => session()->get('id_admin'), // Ambil id_admin dari session
        ]);

        // flash data sukses
        session()->setFlashdata('success', 'Booth berhasil dibuat');

        return redirect()->to('/dashboard/boothlist');
    }

    public function editBooth($slug)
{
    // 1. Langsung ambil data booth dari model
    $boothData = $this->boothModel->getBooth($slug);

    // 2. Jika booth tidak ditemukan, lempar exception
    if (!$boothData) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth dengan id "' . $slug . '" tidak ditemukan');
    }

    // Cek apakah admin sudah login
    if (!session()->has('username_admin')) {
        return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
    }
    
    // 3. Siapkan semua data untuk view dalam satu array
    $data = [
        'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        'booth' => $boothData // Data booth langsung dimasukkan ke key 'booth'
    ];

    // 4. Kirim data ke view
    return view('layout/header', ['title' => 'Edit ' . $boothData['nama_booth']])
        . view('booth/edit', $data) // Kirim seluruh array $data
        . view('layout/footer');
}

    public function updateBooth($id)
{
    // Cek apakah admin sudah login
    $session = session();
    if (!$session->has('id_admin')) {
        return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Aturan validasi
    $rules = [
        'nama_booth' => [
            // Pastikan 'id_booth' cocok dengan nama primary key di tabel Anda
            'rules' => 'required|is_unique[booths_table.nama_booth,id_booth,' . $id . ']|min_length[3]|max_length[50]',
            'errors' => [
                'required' => 'Nama booth harus diisi',
                'is_unique' => 'Nama booth sudah terdaftar',
                'min_length' => 'Nama booth minimal 3 karakter',
                'max_length' => 'Nama booth maksimal 50 karakter',
            ]
        ],
        'deskripsi_booth' => [
            'rules' => 'required|min_length[10]|max_length[255]',
            'errors' => [
                'required' => 'Deskripsi booth harus diisi',
                'min_length' => 'Deskripsi booth minimal 10 karakter',
                'max_length' => 'Deskripsi booth maksimal 255 karakter',
            ]
        ],
        'jenis_booth' => [
            // Menambahkan 'lainnya' agar sesuai dengan form
            'rules' => 'required|in_list[makanan & minuman,komunitas,merchandise,lainnya]',
            'errors' => [
                'required' => 'Jenis booth harus diisi',
                'in_list' => 'Jenis booth harus berupa makanan & minuman, komunitas, merchandise, atau lainnya',
            ]
        ],
        'gambar_booth' => [
            'label' => 'Gambar',
            // [FIX] Mengganti 'gambar_event' menjadi 'gambar_booth'
            'rules' => 'max_size[gambar_booth,500]|is_image[gambar_booth]|mime_in[gambar_booth,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size' => 'Ukuran gambar terlalu besar (maks 500KB).',
                'is_image' => 'Yang Anda pilih bukan gambar.',
                'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
            ]
        ],
        'lokasi_booth' => [
            'rules' => 'required|min_length[10]|max_length[255]',
            'errors' => [
                'required' => 'Lokasi booth harus diisi',
                'min_length' => 'Lokasi booth minimal 10 karakter',
                'max_length' => 'Lokasi booth maksimal 255 karakter',
            ]
        ],
        'kontak_booth' => [
            'rules' => 'required|min_length[10]|max_length[255]',
            'errors' => [
                'required' => 'Kontak booth harus diisi',
                'min_length' => 'Kontak booth minimal 10 karakter',
                'max_length' => 'Kontak booth maksimal 255 karakter',
            ]
        ]
    ];

    if (!$this->validate($rules)) {
        // [IMPROVEMENT] Menggunakan $id dari parameter untuk redirect
        return redirect()->to('/booth/edit/' . $id)->withInput()->with('validation', \Config\Services::validation());
    }

    $fileGambar = $this->request->getFile('gambar_booth');
    $namaGambar = $this->request->getVar('gambar_booth_lama');

    // Cek jika ada gambar baru yang di-upload
    if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
        $namaGambarBaru = $fileGambar->getRandomName();
        $fileGambar->move(FCPATH . 'uploads/images', $namaGambarBaru);

        // [FIX] Gunakan variabel $namaGambar yang sudah berisi nama file lama
        if ($namaGambar && file_exists(FCPATH . 'uploads/images/' . $namaGambar)) {
            unlink(FCPATH . 'uploads/images/' . $namaGambar);
        }

        // Ganti nama gambar ke yang baru
        $namaGambar = $namaGambarBaru;
    }

    // [FIX] Menambahkan 'id_booth' agar model melakukan UPDATE bukan INSERT
    $this->boothModel->save([
        'id_booth' => $id,
        'nama_booth' => $this->request->getVar('nama_booth'),
        'slug' => url_title($this->request->getVar('nama_booth'), '-', true),
        'deskripsi_booth' => $this->request->getVar('deskripsi_booth'),
        'gambar_booth' => $namaGambar,
        'jenis_booth' => $this->request->getVar('jenis_booth'),
        'lokasi_booth' => $this->request->getVar('lokasi_booth'),
        'kontak_booth' => $this->request->getVar('kontak_booth'),
        'id_admin' => $session->get('id_admin'),
    ]);

    session()->setFlashdata('success', 'Booth berhasil diperbarui');

    return redirect()->to('/dashboard/boothlist'); // Disarankan redirect ke list booth
}

    public function deleteBooth($id)
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $booth = $this->boothModel->find($id);
        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        $this->boothModel->delete($id);

        // Hapus gambar jika ada
        if ($booth['gambar_booth']) {
            $gambarPath = WRITEPATH . 'uploads/' . $booth['gambar_booth'];
            // Cek apakah file gambar ada sebelum menghapus
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }

        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'Booth berhasil dihapus');
        return redirect()->to('/dashboard/booth');
    }
}