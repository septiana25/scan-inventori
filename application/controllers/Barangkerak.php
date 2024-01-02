<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barangkerak extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $is_login    = $this->session->userdata('is_login');

        if (!$is_login) {
            redirect(base_url('login'));
            return;
        }
    }

    public function index($id)
    {
        /* Begin Curl */
        $this->load->helper('curl');

        $url = $this->config->item('base_url_api') . "/po";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        /* END Curl */
        $result = json_decode($response);

        $itemQty = $this->barangkerak->fetchByIdMasukIdItem($id, $result->data);

        $data['title'] = 'Manage Masuk';
        $data['nav'] = 'Masuk - Barang Ke Rak';
        $data['content'] = $itemQty;
        $data['page'] = 'pages/masuk/barangkerak';
        $this->view($data);
    }
}

/* End of file Barangkerak.php */