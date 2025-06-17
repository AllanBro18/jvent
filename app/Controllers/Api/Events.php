<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\EventModel;

class Events extends ResourceController 
{
    protected $eventModel;
    protected $format = 'json';

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    /**
     * GET api/events
     */
    public function index () 
    {
        return $this->respond($this->eventModel->findAll());
    }

    /** 
     * Mengambil satu data event berdasarkan slug
     * @param string $slug
    */
    public function show($slug = null)
    {
        $event = $this->eventModel->getEvent($slug);

        if ($event) {
            return $this->respond($event);
        }

        return $this->failNotFound('Event tidak ditemukan...');
    }
}