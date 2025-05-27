<?php

namespace App\Controllers;

class EventController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Detail Event'
        ];
        echo view('layout/header', $data);
        echo view('event/index');
        echo view('layout/footer');
    }
}
