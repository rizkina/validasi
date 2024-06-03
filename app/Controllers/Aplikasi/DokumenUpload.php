<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DokumenUpload extends BaseController
{
    public function index()
    {
        return view('aplikasi/referensi/dokumen');
    }
}
