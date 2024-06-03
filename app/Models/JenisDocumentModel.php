<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisDocumentModel extends Model
{
    protected $table            = 'jenisdocument';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['DocNo', 'NamaDokumen', 'StatusDok'];

    
}
