<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Excel $excel
 * @property Keluar_model $keluar
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Keluar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($no_plat = 0)
    {

        $result = $this->keluar->fetchAll();

        $data['title'] = 'Form Keluar Scan';
        $data['nav'] = 'Keluar - Scan Kendaraan';
        $data['content'] = $result;
        $data['form_action'] = "keluar/create/$no_plat";
        $data['page'] = "pages/keluar/index";
        $this->view($data);
    }

    public function print($nopol)
    {
        $result = $this->keluar->print($nopol);

        // Buat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'SUPIR');
        $sheet->setCellValue('B1', 'TOKO');
        $sheet->setCellValue('C1', 'ITEM');
        $sheet->setCellValue('D1', 'QTY');
        $sheet->setCellValue('E1', 'TANGGAL');
        $sheet->setCellValue('F1', 'USER SCAN');

        // Isi data
        $row = 2;
        foreach ($result as $item) {
            $sheet->setCellValue('A' . $row, $item->supir);
            $sheet->setCellValue('B' . $row, $item->toko);
            $sheet->setCellValue('C' . $row, $item->brg);
            $sheet->setCellValue('D' . $row, $item->qty_scan);
            $sheet->setCellValue('E' . $row, date('Y-m-d H:i:s', strtotime($item->at_create)));
            $sheet->setCellValue('F' . $row, $item->user);
            $row++;
        }

        // Auto-size kolom
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Buat writer untuk output Xlsx
        $writer = new Xlsx($spreadsheet);

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Hasil_Scan_Keluar_' . $nopol . '-' . date('YmdHis') . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Output file ke browser
        $writer->save('php://output');
    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueKeluar()
    {

        return (object) $this->keluar->getDefaultValues();
    }
}

/* End of file Keluar.php */
