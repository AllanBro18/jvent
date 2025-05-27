<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller 
{
    protected $userModel;

    public function __construct()
    {
        // $this->userModel = new UserModel();
    }

    public function index() 
    {
        $data = [
            'title' => 'Halaman Login'
        ];

        echo view('layout/header');
        echo view('login/login_view', $data);
        echo view('layout/footer');
    }

    public function login() {
        // validasi input
        if (!$this->validate([
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => 'format {field} tidak valid',
                    ]
                ],
            'password' => [
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
        $model = $this->userModel;

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'logged_in' => true
                ]);
                return redirect()->to('/user');
            } else {
                return redirect()->to('/login');
            }
        } else {
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function showRegister() {
        $data = [
            'title' => 'Halaman Register'
        ];

        echo view('layout/header');
        echo view('register/register_view', $data);
        echo view('layout/footer');
    }

    public function register() {
        // validasi input
        if (!$this->validate([
            'username' => [
                'rules' => 'required|min_length[4]|is_unique[user.username]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length[4]' => '{field} minimal 4 huruf',
                    'is_unique' => '{field} sudah terdaftar',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => '{field} harus diisi',
                    'is_unique' => '{field} sudah terdaftar',
                    ]
                ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length[6]' => '{field} minimal 6 huruf',
                ]
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
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
        $model = $this->userModel;

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('password_confirm');

        // simpan user baru
        $model->save([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $session->setFlashdata('pesan', 'Registrasi berhasil, silakan login');
        return redirect()->to('/login');
    }
}
