<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use App\Models\JenisDocumentModel;


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

    public function exportToExcel()
    {
        // Get the selected value from the request
        $selectedStatusExcel = $this->request->getGet('statusexcel');

        // Call the exportToExcel() function passing the selected value
        $this->exportToExcelWithData($selectedStatusExcel);
    }

    public function exportToExcelWithData($selectedStatusExcel)
    {
        // Load the model
        $model = $this->dokumenModel;

        // Fetch data from the database based on StatusDok
        $data = $this->dokumenModel->getDataDokumenByStatus($selectedStatusExcel);

        // Filter out rows with blank values if "All" is not selected
        if ($selectedStatusExcel !== "") {
            $filteredData = array_filter($data, function ($row) {
                // Filter condition: Exclude rows where any value is blank
                return !in_array("", $row);
            });
        } else {
            // If "All" is selected, no filtering needed
            $filteredData = $model->findAll();
        }
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row
        $sheet->setCellValue('A1', 'DAFTAR KELENGKAPAN DOKUMEN PPDB 2024');
        $sheet->setCellValue('A2', '');
        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'DocNo');
        $sheet->setCellValue('C3', 'NamaDokumen');
        $sheet->setCellValue('D3', 'StatusDok');

        // Add data rows
        $rowNum = 4;
        foreach ($filteredData as $row) {
            $sheet->setCellValue('A' . $rowNum, $row['ID']);
            $sheet->setCellValue('B' . $rowNum, $row['DocNo']);
            $sheet->setCellValue('C' . $rowNum, $row['NamaDokumen']);
            $sheet->setCellValue('D' . $rowNum, $row['StatusDok']);
            $rowNum++;
        }

        // Set the filename
        $filename = 'Daftar Dokumen PPDB.xlsx';

        // Create the writer
        $writer = new Xlsx($spreadsheet);

        // Send the file to the browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
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
