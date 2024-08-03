<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PickerSo extends MY_Controller
{
    public function index($page = 1)
    {
        $this->load->helper('curl');

        try {
            $url = $this->config->item('base_url_api') . "/so";
            $apiKey = $this->config->item('api_key'); // Simpan API key di konfigurasi
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            if (!$result || !isset($result->data->so)) {
                throw new Exception('Data SO tidak valid');
            }

            $perPage = 10; // Jumlah item per halaman
            $totalItems = count((array) $result->data->so);

            $data['content'] = array_slice((array) $result->data->so, ($page - 1) * $perPage, $perPage);
            $data['totalPages'] = ceil($totalItems / $perPage);
            $data['currentPage'] = $page;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data PO: ' . $e->getMessage());
            $data['content'] = new stdClass(); // Objek kosong jika terjadi error
            $data['totalPages'] = 1;
            $data['currentPage'] = 1;
            $this->session->set_flashdata('error', 'Gagal mengambil data PO');
        }

        $data['title'] = 'Form Keluar';
        $data['nav'] = 'Keluar - Picker SO';
        $data['page'] = 'pages/pickerso/index';
        $this->view($data);
    }
}
