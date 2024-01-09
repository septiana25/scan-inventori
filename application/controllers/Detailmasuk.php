<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detailmasuk extends MY_Controller
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


    public function index($barcodeRak, $id)
    {

        if ($this->validateIdMasuk($id)) {
            redirect(base_url("masuk"));
        }

        $this->load->helper('curl');

        $this->load->helper('curl');
        $url = $this->config->item('base_url_api') . "/shelves/$barcodeRak";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        if ($result == NULL) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url("masuk"));
        }

        if (!empty($result->statusCode) && $result->statusCode == 404) {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
            redirect(base_url("masuk/$id"));
        }

        if (empty($result->data->shelf)) {
            $this->session->set_flashdata('error', 'Data Tidak Ada');
            redirect(base_url("rakmasuk/$id"));
        }

        $idRak = $result->data->shelf->idRak;
        $rak = $result->data->shelf->rak;

        $url = $this->config->item('base_url_api') . "/po/$id";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        $fetchByidMasuk = $this->detailmasuk->fetchByIdMasuk($id);
        if ($fetchByidMasuk == NULL) {
            $fetchByidMasuk = new stdClass();
            $fetchByidMasuk->suratJalan = $result->data->po->suratJln;
        }
        $fetchByidMasuk->rak = $rak;
        $fetchByidMasuk->id_masuk = $id;

        /*  $resultDetailMasuk = $this->detailmasuk->fetchById($id);
        $totalQty = $resultDetailMasuk->totalQty;  */

        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Barang';
        $data['input'] = $this->defalutValueMasukDet($idRak, $rak, $id);
        $data['contentHeader'] = $fetchByidMasuk;
        $data['content'] = $this->detailmasuk->fetchById($id, $rak);
        $data['form_action'] = "detailmasuk/create/$barcodeRak/$id";
        $data['page'] = "pages/masuk/detailmasuk";
        $this->view($data);
    }

    public function create($barcodeRak, $id)
    {

        $this->load->helper('curl');

        if (!$_POST) {
            $input = $this->defalutValueMasukDet($idRak = null, $rak = null, $id);
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if ($this->validateIdMasuk($id) || $this->validateIdMasuk($input->id_masuk)) {
            $this->session->set_flashdata('error', 'Data Masuk Tidak Sesuai');
            redirect(base_url("masuk"));
        }

        if (!$this->detailmasuk->validate()) {
            $data['title'] = 'Form Masuk Scan';
            $data['nav'] = 'Masuk - Scan Barang';
            $data['input'] = $input;
            $data['content'] = $this->detailmasuk->fetchById($id);
            $data['form_action'] = "detailmasuk/create/$barcodeRak/$id";
            $data['page'] = "pages/masuk/detailmasuk";
            $this->view($data);
            return;
        }

        $url = $this->config->item('base_url_api') . "/item/$input->barcode/$id";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        if ($result == NULL) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url("detailmasuk/$barcodeRak/$id"));
        }

        if (!empty($result->statusCode) && $result->statusCode == 404) {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
            redirect(base_url("detailmasuk/$barcodeRak/$id"));
        }

        if ($result->status == 'fail') {
            $this->session->set_flashdata('error', 'Barcode Tidak Ada');
            redirect(base_url("detailmasuk/$barcodeRak/$id"));
        }

        $input->id_item = $result->data->item->idBrg;
        $input->item = $result->data->item->brg;
        $input->qty = $result->data->item->qty;
        $input->username = $this->session->userdata('username');

        if ($this->detailmasuk->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');

            redirect(base_url("detailmasuk/$barcodeRak/$id"));
        } else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url("detailmasuk/$barcodeRak/$id"));
        }
    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueMasukDet($idRak, $rak, $id)
    {

        return (object) $this->detailmasuk->getDefaultValues($idRak, $rak, $id);
    }

    /**
     * validasi jika, id_masuk di tabel masuk tidak ada
     */
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
}

/* End of file Detailmasuk.php */
