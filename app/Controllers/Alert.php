<?php

namespace App\Controllers;

class Alert extends BaseController
{
    public function login()
    {
        session()->setFlashdata('alert', 'Anda harus login terlebih dahulu!');
        session()->setFlashdata('alert_type', 'warning');
        return redirect()->to('/alert');
    }

    public function success()
    {
        session()->setFlashdata('alert', 'Login berhasil!');
        session()->setFlashdata('alert_type', 'success');
        return redirect()->to('/alert');
    }

    public function error()
    {
        session()->setFlashdata('alert', 'Username atau password salah!');
        session()->setFlashdata('alert_type', 'error');
        return redirect()->to('/alert');
    }
}