<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rakmasuk extends MY_Controller
{
    public function index($id)
    {

        $this->loadModelMasuk();

        if ($this->validateIdMasuk($id)) {

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
                redirect(base_url("masuk/$id"));
            }

            if (empty($result->data->po)) {
                $this->session->set_flashdata('error', 'Data Tidak Ada');
                redirect(base_url("masuk/$id"));
            }

            if ($this->masuk->run($result->data->po)) {
                $this->session->set_flashdata('success', 'Berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan Masuk');
                redirect(base_url("masuk/$id"));
            }
        }

        $data['title'] = 'Form Masuk Scan';
        $data['nav'] = 'Masuk - Scan Rak';
        $data['input'] = $this->defalutValueRakMasuk($id);
        $data['content'] = $this->masuk->fetchById($id);
        $data['form_action'] = "rakmasuk/create/$id";
        $data['page'] = "pages/masuk/rak";
        $this->view($data);
    }

    public function create($id)
    {

        $this->loadModelMasuk();

        if (!$_POST) {
            $input = $this->defalutValueRakMasuk($id);
        } else {
            $input = (object) $this->input->post(null, true);
        }


        if ($this->validateIdMasuk($id) && $this->validateIdMasuk($input->id_masuk)) {
            $this->session->set_flashdata('error', 'Data Masuk Tidak Sesuai');
            redirect(base_url("masuk"));
        }

        if (!$this->rakmasuk->validate()) {
            $data['title'] = 'Form Masuk Scan';
            $data['nav'] = 'Masuk - Scan Rak';
            $data['input'] = $input;
            $data['content'] = $this->masuk->fetchById($id);
            $data['form_action'] = "rakmasuk/create/$id";
            $data['page'] = "pages/masuk/rak";
            $this->view($data);
            return;
        }

        $this->load->helper('curl');
        $url = $this->config->item('base_url_api') . "/shelves/$input->barcodeRak";
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

        redirect(base_url("detailmasuk/$input->barcodeRak/$id"));
    }

    public function defalutValueRakMasuk($id)
    {

        return (object) $this->rakmasuk->getDefaultValues($id);
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