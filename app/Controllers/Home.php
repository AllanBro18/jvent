<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jvent'
        ];
        echo view('layout/header', $data);
        echo view('home/index');
        echo view('layout/footer');
    }
}
