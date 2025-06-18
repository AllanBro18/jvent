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

        return view('login/login_view', $data);
    }

    public function loginPost () {
        // validasi input
        if (!$this->validate([
            'username_admin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'username harus diisi',
                ]
            ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'password harus diisi',
                    'min_length[6]' => 'password minimal 6 huruf',
                ]
            ]
        ])) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // set session untuk admin
        $session = session();
        $model = $this->adminModel;

        // ambil field dari input
        $username_admin = $this->request->getPost('username_admin');
        $password_admin = $this->request->getPost('password_admin');

        // cek apakah input sesuai dengan data di database
        $admin = $model->where('username_admin', $username_admin)->first();

        // cek apakah admin ada dan verify password
        if ($admin && password_verify($password_admin, $admin['password_admin'])) {
            // jika ada, session akan di set 
            $session->set([
                'id_admin'       => $admin['id_admin'],
                'username_admin' => $admin['username_admin'],
                'email_admin' => $admin['email_admin'],
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

        return view('register/register_view', $data);
    }

    public function register() {
        // validasi input
        if (!$this->validate([
            'username_admin' => [
                'rules' => 'required|is_unique[admin.username_admin]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username sudah terdaftar',
                ]
            ],
            'email_admin' => [
                'rules' => 'required|valid_email|is_unique[admin.email_admin]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email harus valid',
                    'is_unique' => 'Email sudah terdaftar',
                    ]
                ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length[6]' => 'Password minimal 6 huruf',
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password_admin]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches[password]' => 'Konfirmasi password tidak sama',
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
        $email_admin = $this->request->getPost('email_admin');
        $password_admin = $this->request->getPost('password_admin');

        // simpan user baru
        $model->save([
            'username_admin' => $username_admin,
            'email_admin' => $email_admin,
            'password_admin' => password_hash($password_admin, PASSWORD_DEFAULT),
        ]);

        $session->setFlashdata('pesan', 'Registrasi Admin berhasil, silakan login');
        return redirect()->to('/login');
    }

    public function update ($id) {
        // validasi input
        if (!$this->validate([
            'username_admin' => [
                'rules' => 'required|is_unique[admin.username_admin, id_admin, ' . $id . ']',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username sudah terdaftar',
                ]
            ],
            'email_admin' => [
                'rules' => 'required|valid_email|is_unique[admin.email_admin, id_admin, ' . $id . ']',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email harus valid',
                    'is_unique' => 'Email sudah terdaftar',
                    ]
                ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length[6]' => 'Password minimal 6 huruf',
                ]
            ]
        ])) { // jika tidak valid
            // pesan kesalahan
            $validation = \Config\Services::validation();
            dd($validation->getErrors());

            // input pengguna dan validasi yang didapat akan dikembalikan menjadi pesan
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        
        $session = session();
        $model = $this->adminModel;

        $username_admin = $this->request->getPost('username_admin');
        $email_admin = $this->request->getPost('email_admin');
        $password_admin = $this->request->getPost('password_admin');

        // simpan user baru
        $model->save([
            'id_admin' => $id,
            'username_admin' => $username_admin,
            'email_admin' => $email_admin,
            'password_admin' => password_hash($password_admin, PASSWORD_DEFAULT),
        ]);

        $session->setFlashdata('pesan', 'Perubahan Data Admin berhasil');
        return redirect()->to('/dashboard/pengaturan');
    }
}
