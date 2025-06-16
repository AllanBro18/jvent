<?php 

namespace App\Controllers;

use App\Models\BoothListModel;
use App\Models\EventModel;

class BoothListController extends BaseController
{
    protected $boothListModel;
    protected $eventModel;

    public function __construct()
    {
        $this->boothListModel = new BoothListModel();
        $this->eventModel = new EventModel();
    }

    // Detail booth tertentu
    public function detailByIdEvent ($id)
    {
        $boothList = $this->boothListModel
            ->getBoothsByEvent($id);

        // dd($this->boothModel->getBoothsByEvent($id));

        if (!$boothList) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Booth tidak ditemukan.");
        }

        return view('layout/header', ['title' => 'Detail Booth'])
            . view('boothlist/detailByIdEvent', [
                // Ambil booth berdasarkan id_booth tertentu
                'booths' => $boothList,
                ...$this->getAdminSession(), // spread array
            ])
            . view('layout/footer');
    }

    public function detailBoothList($id)
    {
        $booth = $this->boothListModel
            ->getBoothById($id);

        // dd($booth);
        // dd($this->boothModel->getBoothsByEvent($id));

        if (!$booth) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Booth tidak ditemukan.");
        }

        return view('layout/header', ['title' => 'Detail Booth'])
            . view('boothlist/detail', [
                // Ambil booth berdasarkan id_booth tertentu
                'booth' => $booth,
                ...$this->getAdminSession(), // spread array
            ])
            . view('layout/footer');
    }

    // CRUD Booth
    public function createBoothList()
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
            . view('boothlist/create', [
                'validation' => $validation,
                'events' => $this->eventModel->getEvent(),
                ...$this->getAdminSession(), // spread array
            ])
            . view('layout/footer');
    }

    public function saveBoothList()
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $rules = [
            'nama_booth' => [ 
                'rules' => 'required|is_unique[booth_table.nama_booth]|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'is_unique' => 'Nama booth sudah terdaftar',
                    'min_length' => 'Nama booth minimal 3 karakter',
                    'max_length' => 'Nama booth maksimal 50 karakter',
                ] 
            ],
            'harga_sewa' => [ 
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'numeric' => 'Harga sewa harus berupa angka',
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
            'status' => [ 
                'rules' => 'required|in_list[tersedia,disewa,tidak tersedia]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'in_list' => 'Status harus berupa tersedia, disewa, atau tidak tersedia',
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

        $this->boothListModel->save([
            'nama_booth' => $this->request->getVar('nama_booth'),
            'slug' => url_title($this->request->getVar('nama_booth'), '-', true),
            'deskripsi_booth' => $this->request->getVar('deskripsi_booth'),
            'gambar_booth' => $namaGambar,
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'status' => $this->request->getVar('status'),
            'id_event' => $this->request->getVar('id_event'), // Pastikan id_event ada di form
        ]);

        // flash data sukses
        session()->setFlashdata('success', 'Booth berhasil dibuat');

        return redirect()->to('/dashboard/boothlist');
    }

    public function editBoothList($id)
    {
        $booth = $this->boothListModel->getBoothById($id);

        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }
        // Cek apakah id_booth valid
        if (!is_numeric($id) || $id <= 0) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('ID Booth tidak valid');
        }
        // Jika tidak ditemukan, lempar exception
        if (!$booth) {
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
            . view('boothlist/edit', [
                'validation' => $validation,
                'booth' => $booth,
                'events' => $this->eventModel->find(),
                ...$this->getAdminSession(), // spread array
            ])
            . view('layout/footer');
    }

    public function updateBoothList($id)
    {
        // dd($this->request->getVar());
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $rules = [
            'nama_booth' => [ 
                'rules' => 'required|is_unique[booth_table.nama_booth, id_booth, ' . $id . ']|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'is_unique' => 'Nama booth sudah terdaftar',
                    'min_length' => 'Nama booth minimal 3 karakter',
                    'max_length' => 'Nama booth maksimal 50 karakter',
                ] 
            ],
            'harga_sewa' => [ 
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nama booth harus diisi',
                    'numeric' => 'Harga sewa harus berupa angka',
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
            'status' => [ 
                'rules' => 'required|in_list[tersedia,disewa,tidak tersedia]',
                'errors' => [
                    'required' => 'Status harus diisi',
                    'in_list' => 'Status harus berupa tersedia, disewa, atau tidak tersedia',
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
            'id_event' => [ 
                'rules' => 'required|is_not_unique[event_table.id_event]',
                'errors' => [
                    'required' => 'Event harus dipilih',
                    'is_not_unique' => 'Event tidak ditemukan',
                ] 
            ],
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->to('/boothlist/edit/' . $this->request->getVar('id_booth'))->withInput()->with('validation', $validation);
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

        $this->boothListModel->save([
            'id_booth' => $id, // Pastikan id_booth ada di form
            'nama_booth' => $this->request->getVar('nama_booth'),
            'slug' => url_title($this->request->getVar('nama_booth'), '-', true),
            'deskripsi_booth' => $this->request->getVar('deskripsi_booth'),
            'gambar_booth' => $namaGambar,
            'harga_sewa' => $this->request->getVar('harga_sewa'),
            'status' => $this->request->getVar('status'),
            'id_event' => $this->request->getVar('id_event'), // Pastikan id_event ada di form
        ]);

        // flash data sukses
        session()->setFlashdata('success', 'Booth berhasil diperbarui');

        return redirect()->to('/dashboard/boothlist');
    }

    public function deleteBoothList($id)
    {
        // Cek apakah admin sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $booth = $this->boothListModel->find($id);
        if (!$booth) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booth tidak ditemukan');
        }

        
        // Hapus gambar jika ada
        if (!empty($booth['gambar_booth']) && file_exists(FCPATH . 'uploads/images/' . $booth['gambar_booth'])) {
            unlink(FCPATH . 'uploads/images/' . $booth['gambar_booth']);
        }
        
        // Hapus data booth dari database
        $this->boothListModel->delete($id);

        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'Booth berhasil dihapus');
        return redirect()->to('/dashboard/boothlist');
    }

    public function searchAndFilter () {
        $keyword = $this->request->getVar('keyword');
        $sort = $this->request->getVar('sort') ?? 'asc';
        $query = $this->eventModel;

        if ($keyword) {
            $query = $query->groupStart()
                        ->like('judul_event', $keyword)
                        ->orLike('lokasi_event', $keyword)
                        ->orLike('organizer', $keyword)
                        ->orLike('kategori_tiket', $keyword)
                        ->groupEnd();
        }

        if ($sort == 'terbaru') {
            $query = $query->orderBy('tanggal_event', 'DESC');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'events' => $query->orderBy('judul_event', strtoupper($sort))->findAll(),
            ...$this->getAdminSession(), // spread array
        ];

        return view('admin/dashboard', $data);
    } 
}