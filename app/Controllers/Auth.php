<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class Auth extends Controller 
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login() 
    {
        $data = [
            'title' => 'Halaman Login Admin'
        ];

        echo view('layout/header', $data);
        echo view('login/login_view');
        echo view('layout/footer');
    }

    public function loginPost () {
        // dd($this->request->getPost());
        // validasi input
        if (!$this->validate([
            'username_admin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length[6]' => '{field} minimal 6 huruf',
                ]
            ]
        ])) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $session = session();
        $model = $this->adminModel;

        $username_admin = $this->request->getPost('username_admin');
        $password_admin = $this->request->getPost('password_admin');

        $admin = $model->where('username_admin', $username_admin)->first();

        if ($admin && password_verify($password_admin, $admin['password_admin'])) {
            $session->set([
                'username_admin' => $admin['username_admin'],
                'password_admin' => $admin['password_admin'],
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau Password Salah!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function showRegister() {
        $data = [
            'title' => 'Halaman Register Admin'
        ];

        echo view('layout/header', $data);
        echo view('register/register_view');
        echo view('layout/footer');
    }

    public function register() {
        // validasi input
        if (!$this->validate([
            'nama_admin' => [
                'rules' => 'required|is_unique[admin.username_admin]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ],
            'username_admin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'email_admin' => [
                'rules' => 'required|valid_email|is_unique[admin.email_admin]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                    ]
                ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length[6]' => '{field} minimal 6 huruf',
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password_admin]',
                'errors' => [
                    'required' => 'konfirmasi password harus diisi',
                    'matches[password]' => '{field} tidak sama',
                ]
            ],
        ])) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        
        $session = session();
        $model = $this->adminModel;

        $nama_admin = $this->request->getPost('nama_admin');
        $username_admin = $this->request->getPost('username_admin');
        $email_admin = $this->request->getPost('email_admin');
        $password_admin = $this->request->getPost('password_admin');
        $confirm  = $this->request->getPost('password_confirm');

        // simpan user baru
        $model->save([
            'nama_admin' => $nama_admin,
            'username_admin' => $username_admin,
            'email_admin' => $email_admin,
            'password_admin' => password_hash($password_admin, PASSWORD_DEFAULT),
        ]);

        $session->setFlashdata('pesan', 'Registrasi Admin berhasil, silakan login');
        return redirect()->to('/login');
    }
}
