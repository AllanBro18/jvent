<?php 

namespace App\Controllers;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('username')) {
            return redirect()->to('/login');
        }

        // Ambil data dari session
        $data = [
            'title' => 'Dashboard User',
            'username' => session()->get('username'),
            'email' => session()->get('email'),
        ];

        return view('user/index', $data);
    }
}