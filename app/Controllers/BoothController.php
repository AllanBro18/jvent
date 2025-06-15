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
                'rules' => 'required|in_list[makanan & minuman,komunitas,merchandise]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'in_list' => 'Jenis booth harus berupa makanan & minuman, komunitas, atau merchandise',
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
        ]);

        // flash data sukses
        session()->setFlashdata('success', 'Booth berhasil dibuat');

        return redirect()->to('/dashboard/boothlist');
    }

    public function editBooth($slug)
    {
        $data = [
            'booth' => $this->boothModel->getBooth($slug)
        ];

        // Jika tidak ditemukan, lempar exception
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }
        
        $validation = \Config\Services::validation();
        // jika ada flashdata dari validasi sebelumnya
        if (session()->getFlashdata('validation')) {
            $validation = session()->getFlashdata('validation');
        }

        return view('layout/header', ['title' => 'Edit Booth'])
            . view('booth/edit', [
                'validation' => $validation,
                'booth' => $data,
            ])
            . view('layout/footer');
    }

    public function updateBooth($id)
    {
        // dd($this->request->getVar());
        
        // Cek apakah admin sudah login
        $session = session();
        if (!$session->has('id_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $rules = [
            'nama_booth' => [ 
                'rules' => 'required|is_unique[booths_table.nama_booth, id_booth, ' . $id . ']|min_length[3]|max_length[50]',
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
                'rules' => 'required|in_list[makanan & minuman,komunitas,merchandise]',
                'errors' => [
                    'required' => 'Status harus diisi',
                    'in_list' => 'Status harus berupa makanan & minuman, komunitas, atau merchandise',
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
            $validation = \Config\Services::validation();
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->to('/booth/edit/' . $this->request->getVar('id_booth'))->withInput()->with('validation', $validation);
        }

        // ambil file gambar
        $fileGambar = $this->request->getFile('gambar_booth');
        $namaGambar = $this->request->getVar('gambar_booth_lama');

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

        $this->boothModel->save([
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

    public function deleteBoothList($id)
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