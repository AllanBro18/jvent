<?php 

namespace App\Controllers;

use App\Models\BoothModel;
use App\Models\ProdukModel;

class BoothController extends BaseController
{
    protected $boothModel;
    protected $produkModel;

    public function __construct()
    {
        $this->boothModel = new BoothModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        // ambil semua data booth dari model dengan pagination
        $data = [
            'booths' => $this->boothModel->paginate(8, 'booth_table'),
            'pager' => $this->boothModel->pager,
        ];

        return view('layout/header', ['title' => 'Booths'])
            . view('booth/index', $data)
            . view('layout/footer');
    }

    public function search ()
    {
        // ambil keyword dari input pencarian
        $keyword = $this->request->getVar('keyword');
        // query builder untuk model event
        $query = $this->boothModel;

        // filter berdasarkan keyword
        if ($keyword) {
            // escape keyword untuk menghindari SQL injection
            $keyword = trim($keyword);
            // groupStart untuk menggabungkan kondisi LIKE dengan OR
            $query = $query->groupStart()
                        ->like('nama_booth', $keyword)
                        ->orLike('jenis_booth', $keyword)
                        ->orLike('deskripsi_booth', $keyword)
                        ->groupEnd();
        }

        // ambil data event sesuai dengan filter dan pagination
        $data = [
            'booths' => $query->paginate(8, 'booth_table'),
            'pager' => $this->boothModel->pager,
        ];

        return view('layout/header', ['title' => 'Filter Booth', 'keyword' => $keyword])
            . view('booth/index', $data)
            . view('layout/footer');
    }

    public function detailBooth ($slug)
    {
        // ambil data booth berdasarkan slug
        $produkBooth = $this->produkModel->findAll();

        $produkBooth = array_filter($produkBooth, function ($produk) use ($slug) {
            return $produk['id_booth'] === $this->boothModel->getBooth($slug)['id_booth'];
        });

        $booth = $this->boothModel->getBooth($slug);

        $data = [
            'booth' => $booth,
            'produk' => $produkBooth,
        ];

        // jika tidak ditemukan, lempar exception
        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        return view('layout/header', ['title' => 'Detail ' . $booth['nama_booth']])
            . view('booth/detail', $data)
            . view('layout/footer');
    }

    public function createBooth()
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }
        
        $validation = \Config\Services::validation();
        // jika ada flashdata dari validasi sebelumnya
        if (session()->getFlashdata('validation')) {
            $validation = session()->getFlashdata('validation');
        }

        $data = [
            'title' => 'Tambah Booth Baru',
            'validation' => $validation,
        ];

        return view('booth/create', $data);
    }

    public function saveBooth()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // validasi input untuk tiap field pada form tambah booth
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
                    'uploaded' => 'Pilih gambar booth terlebih dahulu.',
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
            ]
        ];

        // validasi input
        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            // dd($validation->getErrors());
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // ambil file gambar
        $fileGambar = $this->request->getFile('gambar_booth');

        // Cek apakah file gambar valid
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Gambar tidak valid');
        }

        // simpan gambar ke folder uploads/images dengan nama random
        $namaGambar = $fileGambar->getRandomName();

        // pindahkan file gambar ke folder uploads
        if (!$fileGambar->isValid()) {
            return redirect()->back()->withInput()->with('error', $fileGambar->getErrorString());
        }
        $fileGambar->move(FCPATH . 'uploads/images', $namaGambar);

        // simpan data booth ke database
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

        return redirect()->to('/dashboard/booth');
    }

    public function editBooth($slug)
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // ambil data booth berdasarkan slug
        $data = [
            'title' => 'Ubah Booth ' . $slug,
            'validation' => \Config\Services::validation(),
            'booth' => $this->boothModel->getBooth($slug)
        ];

        // Jika booth tidak ditemukan, lempar exception
        if (!$data['booth']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        return view('booth/edit', $data)
            . view('layout/footer');
    }

    public function updateBooth($id)
    {
        // cek apakah admin sudah login
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // validasi input untuk tiap field pada form edit booth
        $rules = [
            'nama_booth' => [ 
                'rules' => 'required|is_unique[booth_table.nama_booth, id_booth, ' . $id . ']',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'is_unique' => 'Booth sudah terdaftar',
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
                'rules' => 'required|in_list[makanan & minuman,komunitas,merchandise]',
                'errors' => [
                    'required' => 'Jenis harus diisi',
                    'in_list' => 'Jenis booth harus berupa makanan & minuman, komunitas, atau merchandise',
                ] 
            ],
            'gambar_booth' => [
                'label' => 'Gambar',
                'rules' => 'permit_empty|max_size[gambar_event,500]|is_image[gambar_booth]|mime_in[gambar_booth,image/jpg,image/jpeg,image/png]', // Tambahkan permit_empty
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
            ]
        ];

        // validasi input dan rules
        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            // dd($validation->getErrors());
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->to('/booth/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        // ambil file gambar terbaru dan gambar lama
        $fileGambar = $this->request->getFile('gambar_booth');
        $namaGambar = $this->request->getVar('gambar_booth_lama');

        // jika ada gambar baru di-upload
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // buat nama random untuk gambar yang baru
            $namaGambarBaru = $fileGambar->getRandomName();
            // pindahkan gambar ke folder uploads/images
            $fileGambar->move(FCPATH . 'uploads/images', $namaGambarBaru);

            // hapus gambar lama jika ada
            $gambarLama = $this->request->getVar('gambar_booth_lama');
            if (!empty($gambarLama) && file_exists(FCPATH . 'uploads/images/' . $gambarLama)) {
                unlink(FCPATH . 'uploads/images/' . $gambarLama);
            }

            // ganti nama gambar ke yang baru
            $namaGambar = $namaGambarBaru;
        }

        // menyimpan data booth yang telah diperbarui
        $this->boothModel->save([
            'id_booth' => $id, // Pastikan id_booth ada di form
            'nama_booth' => $this->request->getVar('nama_booth'),
            'slug' => url_title($this->request->getVar('nama_booth'), '-', true),
            'deskripsi_booth' => $this->request->getVar('deskripsi_booth'),
            'gambar_booth' => $namaGambar,
            'jenis_booth' => $this->request->getVar('jenis_booth'),
            'lokasi_booth' => $this->request->getVar('lokasi_booth'),
            'kontak_booth' => $this->request->getVar('kontak_booth'),
            'id_admin' => $session->get('id_admin'),
        ]);

        // flash data sukses
        session()->setFlashdata('success', 'Booth berhasil diperbarui');

        return redirect()->to('/dashboard/booth');
    }

    public function deleteBooth($id)
    {
        // cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // ambil data booth berdasarkan id
        $booth = $this->boothModel->find($id);
        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        // hapus gambar jika ada
        if (!empty($booth['gambar_booth']) && file_exists(FCPATH . 'uploads/images/' . $booth['gambar_booth'])) {
            unlink(FCPATH . 'uploads/images/' . $booth['gambar_booth']);
        }

        // hapus data booth dari database
        $this->boothModel->delete($id);
        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'Booth berhasil dihapus');
        return redirect()->to('/dashboard/booth');
    }
}