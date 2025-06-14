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

        return view('layout/header', $data)
        . view('login/login_view')
        . view('layout/footer');
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

        $session = session();
        $model = $this->adminModel;

        $username_admin = $this->request->getPost('username_admin');
        $password_admin = $this->request->getPost('password_admin');

        $admin = $model->where('username_admin', $username_admin)->first();

        if ($admin && password_verify($password_admin, $admin['password_admin'])) {
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

        return view('layout/header', $data)
        . view('register/register_view')
        . view('layout/footer');
    }

    public function register() {
        // validasi input
        if (!$this->validate([
            'username_admin' => [
                'rules' => 'required|is_unique[admin.username_admin]',
                'errors' => [
                    'required' => 'username harus diisi',
                    'is_unique' => 'username sudah terdaftar',
                ]
            ],
            'email_admin' => [
                'rules' => 'required|valid_email|is_unique[admin.email_admin]',
                'errors' => [
                    'required' => 'email harus diisi',
                    'valid_email' => 'email harus valid',
                    'is_unique' => 'email sudah terdaftar',
                    ]
                ],
            'password_admin' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'password harus diisi',
                    'min_length[6]' => 'password minimal 6 huruf',
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password_admin]',
                'errors' => [
                    'required' => 'konfirmasi password harus diisi',
                    'matches[password]' => 'konfirmasi password tidak sama',
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
}
