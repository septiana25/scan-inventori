<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkerso extends MY_Controller
{
    public function index($page = 1)
    {
        $this->load->helper('curl');

        try {

            $result =  $this->checkerso->fetchAll();


            if (empty($result)) {
                throw new Exception('Tidak ada data');
            }
            // Mengelompokkan data berdasarkan nopol
            $groupedData = [];
            foreach ($result as $item) {
                if (!isset($groupedData[$item->nopol])) {
                    $groupedData[$item->nopol] = [
                        'nopol' => $item->nopol,
                        'supir' => $item->supir,
                        'count_toko' => 0,
                    ];
                }
                $groupedData[$item->nopol]['count_toko']++;
            }

            $perPage = 10; // Jumlah item per halaman
            $totalItems = count((array) $groupedData);

            $slicedData = array_slice($groupedData, ($page - 1) * $perPage, $perPage);
            $data['content'] = json_decode(json_encode($slicedData));
            $data['totalPages'] = ceil($totalItems / $perPage);
            $data['currentPage'] = $page;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data SO: ' . $e->getMessage());
            $data['content'] = new stdClass(); // Objek kosong jika terjadi error
            $data['totalPages'] = 1;
            $data['currentPage'] = 1;
            $this->session->set_flashdata('error', 'Gagal mengambil data SO');
        }

        $data['title'] = 'Form Keluar';
        $data['nav'] = 'Keluar - Checker SO';
        $data['page'] = 'pages/checkerso/index';
        $this->view($data);
    }

    public function detail($nopol)
    {
        try {
            $result = $this->checkerso->fetchByNopol($nopol);

            if (empty($result)) {
                throw new Exception('Data SO tidak ditemukan');
            }

            $data['content'] = $result;
            $data['title'] = 'Detail SO';
            $data['nav'] = 'Keluar - List SO';
            $data['page'] = 'pages/checkerso/detail';
            $this->view($data);
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data SO: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat mengambil Ekspedisi');
            redirect(base_url("checkerso"));
        }
    }
}
