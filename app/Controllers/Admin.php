<?php 

namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new AdminModel();
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('username_admin')) {
            return redirect()->to('/login');
        }

        // Ambil data dari session
        $data = [
            'title' => 'Dashboard Admin',
            'username_admin' => session()->get('username_admin'),
            'email_admin' => session()->get('email_admin'),
        ];

        return view('admin/index', $data);
    }
}