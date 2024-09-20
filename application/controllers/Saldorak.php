<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Saldorak_model $saldorak
 */
class Saldorak extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('curl');

        if (!$_POST) {
            $input = $this->defalutValueItems();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (empty($input->barcodeRak)) {
            $resultData = [];
        } else {
            $url = $this->config->item('base_url_api') . "/item/shelf/$input->barcodeRak";
            $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
            $result = json_decode($response);

            if ($result == NULL) {
                $this->session->set_flashdata('error', 'Opps Server API Error');
                redirect(base_url("saldorak"));
            }

            if (!empty($result->statusCode) && $result->statusCode == 404) {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
                redirect(base_url("saldorak"));
            }

            $resultData = $result->data->items;
            if (empty($resultData)) {
                $this->session->set_flashdata('error', 'Data Tidak Ada');
                redirect(base_url("saldorak"));
            }
        }

        $data['title'] = 'Cek Saldo Rak';
        $data['nav'] = 'Cek Saldo Rak';
        $data['input'] = $this->defalutValueItems();
        $data['form_action'] = "saldorak";
        $data['content'] = $resultData;
        $data['page'] = 'pages/saldo/rak';
        $this->view($data);
    }

    public function run() {}

    public function defalutValueItems()
    {

        return (object) $this->saldorak->getDefaultValues();
    }
}

/* End of file Items.php */