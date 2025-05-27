<?php

namespace App\Controllers;

class EventController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Event-Event'
        ];
        echo view('layout/header', $data);
        echo view('event/index');
        echo view('layout/footer');
    }
    
    public function detail()
    {
        $data = [
            'title' => 'Detail Event'
        ];
        echo view('layout/header', $data);
        echo view('event/detail');
        echo view('layout/footer');
    }
}
