<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detailmasuk extends MY_Controller
{


    public function index($id)
    {

        if ($this->validateIdMasuk($id)) {

            $this->load->helper('curl');
            $this->loadModelMasuk();

            $url = $this->config->item('base_url_api') . "/po/$id";
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

            if (empty($result->data[0])) {
                $this->session->set_flashdata('error', 'Data Tidak Ada');
                redirect(base_url("masuk/$id"));
            }

            if ($this->masuk->run($result->data[0])) {
                $this->session->set_flashdata('success', 'Berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan Masuk');
                redirect(base_url("masuk/$id"));
            }
        }

        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Barang';
        $data['input'] = $this->defalutValueMasukDet($id);
        $data['content'] = $this->detailmasuk->fetchById($id);
        $data['form_action'] = "detailmasuk/create/$id";
        $data['page'] = "pages/masuk/detailmasuk";
        $this->view($data);
    }

    public function create($id)
    {

        $this->load->helper('curl');

        if (!$_POST) {
            $input = $this->defalutValueMasukDet($id);
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
            $data['form_action'] = "detailmasuk/create/$id";
            $data['page'] = "pages/masuk/detailmasuk";
            $this->view($data);
            return;
        }

        $url = $this->config->item('base_url_api') . "/item/$input->barcode/$id";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        if ($result == NULL) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url("detailmasuk"));
        }

        if (!empty($result->statusCode) && $result->statusCode == 404) {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
            redirect(base_url("detailmasuk/$id"));
        }

        if ($result->status == 'fail') {
            $this->session->set_flashdata('error', 'Barcode Tidak Ada');
            redirect(base_url("detailmasuk/$id"));
        }

        $input->id_item = $result->data->id_brg;
        $input->item = $result->data->brg;
        $input->qty = $result->data->qty;

        if ($this->detailmasuk->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil disimpan');

            redirect(base_url("detailmasuk/$id"));
        } else {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan');
            redirect(base_url("detailmasuk/$id"));
        }
    }

    /**
     * set defalut input buat function index
     */
    public function defalutValueMasukDet($id)
    {

        return (object) $this->detailmasuk->getDefaultValues($id);
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
