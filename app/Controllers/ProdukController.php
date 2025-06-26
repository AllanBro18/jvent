<?php 
namespace App\Controllers;
use App\Models\ProdukModel;

class ProdukController extends BaseController{
    protected $produkModel;

    public function __construct() {
        $this->produkModel = new ProdukModel();
    }

    public function index() {
        $data['produk'] = $this->produkModel->findAll();
        return view('produk/index', $data);
    }

    public function create() {

        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $data = [
            'title' => 'Tambah Produk',
            'validation' => \Config\Services::validation(),
        ];
        return view('produk/create', $data);
    }

    public function save() {
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $rules = [
            'id_booth' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'ID Booth harus diisi.',
                    'integer' => 'ID Booth harus berupa angka.'
                ]
            ],
            'nama_produk' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama produk harus diisi.',
                    'min_length' => 'Nama produk minimal 3 karakter.',
                    'max_length' => 'Nama produk maksimal 100 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 500 karakter.'
                ]
            ],
            'harga' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'decimal' => 'Harga harus berupa angka desimal.'
                ]
            ],
            'gambar_produk' => [
                'rules' => 'uploaded[gambar_produk]|is_image[gambar_produk]|max_size[gambar_produk,500],mime_in[gambar_produk,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar produk harus diunggah.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'max_size' => 'Ukuran gambar maksimal 500KB.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
                ],
            'status' => [
                'rules' => 'in_list[tersedia,habis,preorder]',
                'errors' => [
                    'in_list' => 'Status harus berupa tersedia, habis, atau preorder.'
                ]
            ],
            'stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stok harus diisi.',
                    'integer' => 'Stok harus berupa angka.'
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // Handle file upload
        $gambarProduk = $this->request->getFile('gambar_produk');
        if ($gambarProduk->isValid() && !$gambarProduk->hasMoved()) {
            $namaFile = $gambarProduk->getRandomName();
            $gambarProduk->move('uploads/produk', $namaFile);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar produk.');
        }
        $this->produkModel->save([
            'id_booth' => $this->request->getPost('id_booth'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'gambar_produk' => $namaFile,
            'status' => $this->request->getPost('status'),
            'stok' => $this->request->getPost('stok')
        ]);
        // Redirect with success message
        session()->setFlashdata('success', 'Produk berhasil ditambahkan.');
        // Redirect to produk index
        return redirect()->to('/produk');
    }

    public function edit($id) {
        $data = [
            'title' => 'Edit Produk',
            'produk' => $this->produkModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('produk/edit', $data);
    }
    public function update($id){
        if(!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        };

        $rules = [
            'id_booth' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'ID Booth harus diisi.',
                    'integer' => 'ID Booth harus berupa angka.'
                ]
            ],
            'nama_produk' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama produk harus diisi.',
                    'min_length' => 'Nama produk minimal 3 karakter.',
                    'max_length' => 'Nama produk maksimal 100 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[500]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 500 karakter.'
                ]
            ],
            'harga' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Harga harus diisi.',
                    'decimal' => 'Harga harus berupa angka desimal.'
                ]
            ],
            'gambar_produk' => [
                'rules' => 'uploaded[gambar_produk]|is_image[gambar_produk]|max_size[gambar_produk,500],mime_in[gambar_produk,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar produk harus diunggah.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'max_size' => 'Ukuran gambar maksimal 500KB.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
                ],
            'status' => [
                'rules' => 'in_list[tersedia,habis,preorder]',
                'errors' => [
                    'in_list' => 'Status harus berupa tersedia, habis, atau preorder.'
                ]
            ],
            'stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stok harus diisi.',
                    'integer' => 'Stok harus berupa angka.'
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // Handle file upload
        $gambarProduk = $this->request->getFile('gambar_produk');
        if ($gambarProduk->isValid() && !$gambarProduk->hasMoved()) {
            $namaFile = $gambarProduk->getRandomName();
            $gambarProduk->move('uploads/produk', $namaFile);
        } else {
            // If no new image is uploaded, keep the old one
            $produk = $this->produkModel->find($id);
            $namaFile = $produk['gambar_produk'];
        }


        $this->produkModel->save([
            'id_produk' => $id,
            'id_booth' => $this->request->getPost('id_booth'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'gambar_produk' => $namaFile,
            'status' => $this->request->getPost('status'),
            'stok' => $this->request->getPost('stok')
        ]);

    }
    public function delete($id) {
        if (!session()->has('username_admin')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        $produk = $this->produkModel->find($id);
        if ($produk) {
            // Delete the product image if it exists
            if (file_exists('uploads/produk/' . $produk['gambar_produk'])) {
                unlink('uploads/produk/' . $produk['gambar_produk']);
            }
            $this->produkModel->delete($id);
            session()->setFlashdata('success', 'Produk berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Produk tidak ditemukan.');
        }
        return redirect()->to('/produk');
    }
}
?>