<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\JenisDocumentModel;


class DokumenUpload extends BaseController
{
    public function index()
    {
        // Load JenisDocumentModel and call the method to get distinct 'StatusDok' values
        $statusValues = $this->dokumenModel->getStatus();

        // Pass the retrieved 'Status' values to the view
        $data['statusValues'] = $statusValues;


        return view('aplikasi/referensi/dokumen', $data);
    }

    public function import()
    {
        $file = $this->request->getFile('fileexcel');
        if ($file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();

            if ($ext === 'xls') {
                $render = IOFactory::createReader('Xls');
            } else {
                $render = IOFactory::createReader('Xlsx');
            }

            $spreadsheet = $render->load($file->getTempName());
            $data = $spreadsheet->getActiveSheet()->toArray();

            $successAdded = 0;
            $successUpdated = 0;
            $failCount = 0;

            foreach ($data as $x => $row) {
                if ($x == 0) { // Skip header row
                    continue;
                }
                $NoDoc = $row[0];
                $NamaDokumen = $row[1];
                $StatusDok = $row[2] ?? 'Aktif'; // Optional third column

                $dokumen = $this->dokumenModel->cekDokumenByNo($NoDoc);

                if ($dokumen) {
                    $affectedRows = $this->dokumenModel->update($dokumen->DocNo, [
                        'DocNo' => $NoDoc,
                        'NamaDokumen' => $NamaDokumen,
                        'StatusDok' => $StatusDok
                    ]);

                    if ($affectedRows > 0) {
                        $successUpdated++;
                    } else {
                        $failCount++;
                    }
                } else {
                    $simpanDokumen = [
                        'DocNo' => $NoDoc,
                        'NamaDokumen' => $NamaDokumen,
                        'StatusDok' => $StatusDok
                    ];

                    if ($this->dokumenModel->insert($simpanDokumen)) {
                        $successAdded++;
                    } else {
                        $failCount++;
                    }
                }
            }

            session()->setFlashdata('pesan', 'Data Baru: ' . $successAdded . ', data diperbaharui: ' . $successUpdated . ', data gagal: ' . $failCount . ' import dari file excel.');

            return redirect()->back();
        } else {
            session()->setFlashdata('pesan', 'Please select a valid Excel file.');
            return redirect()->back();
        }
    }

    public function getDataDokumen()
    {
        $data = $this->dokumenModel->findAll();

        // Fetch all records from the table
        // $data = $model->findAll();

        // Return data as JSON
        return $this->response->setJSON($data);
    }
}
