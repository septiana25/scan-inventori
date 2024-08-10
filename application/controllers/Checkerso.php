<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property Checkerso_model $checkerso
 * @property CI_Pagination $pagination
 */
class Checkerso extends MY_Controller
{
    const PER_PAGE = 10;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('curl');
        $this->load->library('pagination');
        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }
    public function index($page = 1)
    {

        try {

            $result =  $this->checkerso->fetchAllGrouped();

            if (empty($result)) {
                throw new Exception('Tidak ada data');
            }

            $totalItems = count($result);
            $offset = ($page - 1) * self::PER_PAGE;
            $this->pagination->initialize([
                'base_url' => base_url('checkerso/index'),
                'total_rows' => $totalItems,
                'per_page' => self::PER_PAGE,
                'use_page_numbers' => TRUE,
                'cur_page' => $page,
            ]);

            $slicedArray = array_slice($result, $offset, self::PER_PAGE);
            $data['content'] = json_decode(json_encode($slicedArray));
            $data['pagination'] = $this->pagination->create_links();
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
