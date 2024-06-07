<?php

namespace App\Controllers\Aplikasi;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;
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
        $sheet->setCellValue('B3', 'Nomor Dokumen');
        $sheet->setCellValue('C3', 'Nama Dokumen');
        $sheet->setCellValue('D3', 'Status Dokumen');

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

    public function exportToPDF()
    {
        // Get the selected value from the request
        $selectedStatusPDF = $this->request->getGet('statuspdf');

        // Call the exportToPDF() function passing the selected value
        $this->exportToPDFWithData($selectedStatusPDF);
    }

    public function exportToPDFWithData($selectedStatusPDF)
    {
        // Load the model
        $model = $this->dokumenModel;

        // Fetch data from the database based on StatusDok
        $data = $this->dokumenModel->getDataDokumenByStatus($selectedStatusPDF);

        // Filter out rows with blank values if "All" is not selected
        if ($selectedStatusPDF !== "") {
            $filteredData = array_filter($data, function ($row) {
                // Filter condition: Exclude rows where any value is blank
                return !in_array("", $row);
            });
        } else {
            // If "All" is selected, no filtering needed
            $filteredData = $model->findAll();
        }

        // Create new PDF document
        $pdf = new class extends TCPDF {
            public function Header() {
                // Logo
                $image_file = 'assets-app/media/logos/logo_jateng23.png';
                $this->Image($image_file, 10, 10, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            
                // Set font for the first two lines
                $this->SetFont('helvetica', 'B', 12);
                // Title: PEMERINTAH PROVINSI JAWA TENGAH
                $this->Cell(0, 10, 'PEMERINTAH PROVINSI JAWA TENGAH', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                // Line break
                $this->Ln(2); // Adjust the value to change the spacing
                // Title: DINAS PENDIDIKAN DAN KEBUDAYAAN
                $this->Cell(0, 10, 'DINAS PENDIDIKAN DAN KEBUDAYAAN', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                // Line break
                $this->Ln(2); // Adjust the value to change the spacing
                // Set font for the third line
                $this->SetFont('helvetica', 'B', 14);
                // Title: SMK NEGERI 1 KALIWUNGU
                $this->Cell(0, 10, 'SMK NEGERI 1 KALIWUNGU', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                $this->Line(10, $this->GetY(), $this->getPageWidth() - 10, $this->GetY());

            }
            

            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-15);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                // Page number
                $this->Cell(0, 10, 'Hal ' . $this->getAliasNumPage() . ' dari ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
        };

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Rizki');
        $pdf->SetTitle('DAFTAR DOKUMEN ');
        $pdf->SetSubject('Document Data Export');
        $pdf->SetKeywords('PPDB, Daftar Dokumen');

        // Set default header data
        // $pdf->SetHeaderData('', 0, 'Document Data', 'Generated by system', array(0,64,255), array(0,64,128));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // Add a page
        $pdf->AddPage();

        // Set title
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 15, 'DAFTAR KELENGKAPAN DOKUMEN PPDB 2024', 0, 1, 'C');

        // Create HTML content for table
        $html = '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th  width="15%">No Dokumen</th>
                            <th width="60%">Nama Dokumen</th>
                            <th width="15%">Status Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($filteredData as $row) {
            $pdf->SetFont('dejavusans', '', 10);
            $html .= '<tr>
                        <td width="10%">' . $row['ID'] . '</td>
                        <td width="15%">' . $row['DocNo'] . '</td>
                        <td width="60%">' . $row['NamaDokumen'] . '</td>
                        <td width="15%">' . ($row['StatusDok'] == 1 ? 'Aktif' : 'Tidak Aktif') . '</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('DocumentData.pdf', 'D');
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

    public function getData($id)
    {
        // Fetch the document by ID
        $document = Document::find($id);

        if ($document) {
            return response()->json($document);
        } else {
            return response()->json(['error' => 'Document not found'], 404);
        }
    }
}
