<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('aplikasi/dashboard/index');
    }
}
