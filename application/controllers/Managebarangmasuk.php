<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Managebarangmasuk extends MY_Controller
{

    public function index()
    {
        /* Begin Curl */
        $this->load->helper('curl');

        $url = $this->config->item('base_url_api') . "/po";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        /* END Curl */
        $result = json_decode($response);
        $data['title'] = 'Manage Masuk';
        $data['nav'] = 'Masuk - Manage Barang Masuk';
        $data['content'] = $this->managebarangmasuk->fetchByIdMasuk($result->data);
        $data['page'] = 'pages/masuk/managebarang';
        $this->view($data);
    }
}

/* End of file Managebarangmasuk.php */