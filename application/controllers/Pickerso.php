<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property PickerSo_model $pickerso
 */
class PickerSo extends MY_Controller
{
    const PER_PAGE = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('curl');
        $this->load->library('pagination');
        $this->load->helper('pagination');
    }
    public function index($page = 1)
    {
        try {

            $result = $this->pickerso->getAllSO();

            if (!$result || !isset($result->data->so)) {
                throw new Exception('Data SO tidak valid');
            }

            $totalItems = count($result->data->so);
            $offset = ($page - 1) * self::PER_PAGE;

            $slicedArray = array_slice($result->data->so, $offset, self::PER_PAGE);
            $data['content'] = json_decode(json_encode($slicedArray));
            $data['pagination'] = $this->initializePagination($totalItems, $page);
            $data['currentPage'] = $page;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data SO: ' . $e->getMessage());
            $data['content'] = new stdClass(); // Objek kosong jika terjadi error
            $data['totalPages'] = 1;
            $data['currentPage'] = 1;
            $this->session->set_flashdata('error', 'Gagal mengambil data SO');
        }

        $data['title'] = 'Form Keluar';
        $data['nav'] = 'Keluar - Picker SO';
        $data['page'] = 'pages/pickerso/index';
        $this->view($data);
    }

    private function initializePagination($totalItems, $page)
    {
        $config = [
            'base_url' => base_url("pickerso"),
            'total_rows' => $totalItems,
            'per_page' => self::PER_PAGE,
            'use_page_numbers' => TRUE,
            'cur_page' => $page,
            'attributes' => ['class' => 'page-link'],
        ];

        $config = array_merge($config, get_pagination_template());

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
}
