<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisDocumentModel extends Model
{
    protected $table            = 'jenisdocument';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['DocNo', 'NamaDokumen', 'StatusDok'];

    public function cekDokumenByNo($NoDoc)
    {
        $result = $this->where('DocNo', $NoDoc)->get()->getRow();

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function getStatus()
    {
        // Execute a custom SQL query to fetch distinct 'kelas' values
        $query = $this->db->query('SELECT DISTINCT StatusDok FROM jenisdocument');

        // Check if the query executed successfully
        if ($query) {
            // Fetch the result rows
            $result = $query->getResultArray();

            // Check if there are rows returned
            if (!empty($result)) {
                // Initialize an empty array to store 'kelas' values
                $statusValues = [];

                // Fetch 'kelas' values from query result
                foreach ($result as $row) {
                    $statusValues[] = $row['StatusDok'];
                }

                return $statusValues;
            } else {
                // No rows found, return an empty array
                return [];
            }
        } else {
            // Query execution failed, return false or handle the error as needed
            return false;
        }
    }

    public function getDataDokumenByStatus($status)
    {
        // Fetch records where 'status' equals the specified value
        return $this->where('StatusDok', $status)->findAll();
    }
}
