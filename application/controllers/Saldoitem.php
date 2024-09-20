<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Saldoitem_model $saldoitem
 */
class Saldoitem extends MY_Controller
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

        if (empty($input->barcodeItem)) {
            $resultData = [];
        } else {
            $url = $this->config->item('base_url_api') . "/item/item/$input->barcodeItem";
            $response = curl_request($url, 'GET', null, ["X-API-KEY:ian123"]);
            $result = json_decode($response);

            if ($result == NULL) {
                $this->session->set_flashdata('error', 'Opps Server API Error');
                redirect(base_url("saldoitem"));
            }

            if (!empty($result->statusCode) && $result->statusCode == 404) {
                $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
                redirect(base_url("saldoitem"));
            }

            $resultData = $result->data->items;
            if (empty($resultData)) {
                $this->session->set_flashdata('error', 'Data Tidak Ada');
                redirect(base_url("saldoitem"));
            }
        }

        $data['title'] = 'Cek Saldo Item';
        $data['nav'] = 'Cek Saldo Item';
        $data['input'] = $this->defalutValueItems();
        $data['form_action'] = "saldoitem";
        $data['content'] = $resultData;
        $data['page'] = 'pages/saldo/item';
        $this->view($data);
    }

    public function run() {}

    public function defalutValueItems()
    {

        return (object) $this->saldoitem->getDefaultValues();
    }
}

/* End of file Items.php */