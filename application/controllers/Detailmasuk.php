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
        $url = $this->config->item('base_url_api') . "/shelves/$barcodeRak";
        $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($response);

        if ($result == NULL) {
            $this->handleError('Opps Server API Error', "masuk");
        }

        if (!empty($result->statusCode) && $result->statusCode == 404) {
            $this->handleError('Opps Terjadi Kesalahan URL API', "masuk/$id");
        }

        if (empty($result->data->shelf)) {
            $this->handleError('Data Tidak Ada', "rakmasuk/$id");
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
            $this->handleError('Opps Terjadi Kesalahan', "masuk");
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

        $urlItem = $this->config->item('base_url_api') . "/item/$input->barcode/$id";
        $responseItem = curl_request($urlItem, 'GET', null, ["X-API-KEY:ian123"]);
        $result = json_decode($responseItem);

        $urlItemRak = $this->config->item('base_url_api') . "/item/shelf/$input->rak";
        $responseItemRak = curl_request($urlItemRak, 'GET', null, ["X-API-KEY:ian123"]);
        $resultItemRak = json_decode($responseItemRak);

        if ($result == NULL || $resultItemRak == NULL) {
            $this->handleError('Opps Server API Error', "detailmasuk/$barcodeRak/$id");
        }

        if ((!empty($result->statusCode) && $result->statusCode == 404) || (!empty($resultItemRak->statusCode) && $resultItemRak->statusCode == 404)) {
            $this->handleError('Opps Server API Error', "detailmasuk/$barcodeRak/$id");
        }

        if ($result->status == 'fail' || $resultItemRak->status == 'fail') {
            $this->handleError('Barcode Tidak Ada', "detailmasuk/$barcodeRak/$id");
        }

        // todo : validasi jika item di rak penuh
        $input->id_item = $result->data->item->idBrg;
        $input->item = $result->data->item->brg;
        $input->qty = intval($result->data->item->qty);
        $input->manager = "";
        $input->username = $this->session->userdata('username');
        $totalSaldoAkhir = 0;

        if (isset($resultItemRak->data->items)) {
            foreach ($resultItemRak->data->items as $item) {
                $totalSaldoAkhir += intval($item->saldo_akhir);
            }
        }

        $limitRak = isset($result->data->item->limit_rak) ? intval($result->data->item->limit_rak) : 0;

        if (!isset($input->qty) || !is_numeric($input->qty)) {
            $this->handleError('Invalid QTY', "detailmasuk/$barcodeRak/$id");
        }

        $totalRakPlusQty = $limitRak + $input->qty;

        if ($totalRakPlusQty > $totalSaldoAkhir) {
            $this->loadModelApprovedRak();
            $resultApprovedRak = $this->approvedrak->fetchByIdMasukIdRak($id, $input->id_rak);

            if ($resultApprovedRak == NULL) {
                if ($this->approvedrak->run($input)) {
                    $this->handleError('Rak Penuh', "detailmasuk/$barcodeRak/$id");
                } else {
                    $this->handleError('Opps Terjadi Kesalahan', "detailmasuk/$barcodeRak/$id");
                }
            }

            if ($resultApprovedRak->approve == 'false' || $resultApprovedRak->approve == 'cancel') {
                $this->handleError('Rak Penuh, Hub.Manager', "detailmasuk/$barcodeRak/$id");
            }

            $input->manager = $resultApprovedRak->manager;
        }

        if ($this->detailmasuk->run($input)) {
            $this->handleSuccess('Berhasil disimpan', "detailmasuk/$barcodeRak/$id");
        } else {
            $this->handleError('Opps Terjadi Kesalahan', "detailmasuk/$barcodeRak/$id");
        }
    }

    /**
     * set defalut input buat function index
     */
    private function defalutValueMasukDet($idRak, $rak, $id)
    {

        return (object) $this->detailmasuk->getDefaultValues($idRak, $rak, $id);
    }

    /**
     * validasi jika, id_masuk di tabel masuk tidak ada
     */
    private function validateIdMasuk($id)
    {
        $this->loadModelMasuk();
        $masuk = $this->masuk->totalRowsMasuk($id);
        if ($masuk < 1) {
            return true;
        }
    }

    private function loadModelMasuk()
    {
        $this->load->model(ucfirst('masuk') . '_model', 'masuk', true);
        return $this;
    }

    private function loadModelApprovedRak()
    {
        $this->load->model(ucfirst('approvedrak') . '_model', 'approvedrak', true);
        return $this;
    }

    private function handleError($message, $url)
    {
        $this->session->set_flashdata('error', $message);
        redirect(base_url($url));
    }

    private function handleSuccess($message, $url)
    {
        $this->session->set_flashdata('success', $message);
        redirect(base_url($url));
    }
}

/* End of file Detailmasuk.php */
