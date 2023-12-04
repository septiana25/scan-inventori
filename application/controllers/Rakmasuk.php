<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rakmasuk extends MY_Controller
{
    public function index($id)
    {

        if ($this->validateIdMasuk($id)) {
            $this->session->set_flashdata('error', 'Data Tidak Ada');
            redirect(base_url("masuk"));
        }

        $this->load->helper('curl');

        $url = $this->config->item('base_url_api') . "/po/$id";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        if ($result == NULL) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url("masuk"));
        }

        if (!empty($result->statusCode) && $result->statusCode == 404) {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
            redirect(base_url("masuk"));
        }

        if (empty($result->data[0])) {
            $this->session->set_flashdata('error', 'Barcode Rak Tidak Ada');
            redirect(base_url("masuk"));
        }

        $this->loadModelDetailMasuk();

        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Rak';
        $data['input'] = $this->defalutValueRakMasuk($id);
        $data['content'] = $this->detailmasuk->fetchById($id);
        $data['form_action'] = "rakmasuk/create/$id";
        $data['page'] = "pages/masuk/rak";
        $this->view($data);
    }

    public function defalutValueRakMasuk($id)
    {

        return (object) $this->detailmasuk->getDefaultValues($id);
    }


    public function validateIdMasuk($id)
    {
        $this->loadModelMasuk();
        $masuk = $this->masuk->totalRowsMasuk($id);
        if ($masuk < 1) {
            return true;
        }
    }

    public function loadModelMasuk()
    {
        $this->load->model(ucfirst('masuk') . '_model', 'masuk', true);
        return $this;
    }

    public function loadModelDetailMasuk()
    {
        $this->load->model(ucfirst('detailmasuk') . '_model', 'detailmasuk', true);
        return $this;
    }
}

/* End of file Rakmasuk.php */