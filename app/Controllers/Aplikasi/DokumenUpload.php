<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JenisDocumentModel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class DokumenUpload extends BaseController
{
    public function index()
    {
        return view('aplikasi/referensi/dokumen');
    }

    public function import()
    {
        $file = $this->request->getFile('fileexcel');

        if ($file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $jenisDocumentModel = new JenisDocumentModel();

            foreach ($sheetData as $key => $data) {
                if ($key == 0) {
                    continue; // Skip header row
                }

                $insertData = [
                    'DocNo' => $data[0],
                    'NamaDokumen' => $data[1],
                ];

                // Optionally add StatusDok if it exists in the Excel file
                if (isset($data[2])) {
                    $insertData['StatusDok'] = $data[2];
                }

                $jenisDocumentModel->insert($insertData);
            }

            return redirect()->to('/unggahdokumen')->with('message', 'Data imported successfully.');
        } else {
            return redirect()->to('/unggahdokumen')->with('message', 'Please select a valid Excel file.');
        }
    }

    public function datadokumen()
    {
        $model = new JenisDocumentModel();

        // Fetch all records from the table
        $data = $model->findAll();

        // Return data as JSON
        return $this->respond($data);
    }
}
