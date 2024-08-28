<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property Returns_model $returns
 */
class Returns extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('curl');
    }

    public function index()
    {
        try {
            if (!$_POST) {
                $input = $this->defalutValueReturns();
            } else {
                $input = (object) $this->input->post(null, true);
            }

            if (!empty($input->barcodeRak)) {
                $url = $this->config->item('base_url_api') . "/shelves/$input->barcodeRak";
                $apiKey = $this->config->item('api_key');
                $responseRak = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
                $resultRak = json_decode($responseRak);

                $this->validateResponse($responseRak);
                $this->validateDataResult($resultRak->data->shelf);
                $idRak = $resultRak->data->shelf->idRak;

                redirect(base_url("returns/detail/$idRak"));
            }

            $url = $this->config->item('base_url_api') . "/returns";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            $this->validateResponse($response);
            $this->validateDataResult($result->data->returns);

            $data['content'] = $result->data->returns;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Retur: ' . $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Data Returns';
        $data['nav'] = 'Retur - Scan Rak';
        $data['input'] = $this->defalutValueReturns();
        $data['form_action'] = "returns";
        $data['page'] = 'pages/retur/index';
        $this->view($data);
    }


    public function detail()
    {
        $data['title'] = 'Detail Returns';
        $data['nav'] = 'Retur - Scan Rak';
        $data['page'] = 'pages/retur/detail';
        $this->view($data);
    }

    private function defalutValueReturns()
    {

        return (object) $this->returns->getDefaultValues();
    }

    private function validateResponse($response)
    {
        if ($response == NULL) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url("returns"));
        }

        if (!empty($response->statusCode) && $response->statusCode == 404) {
            $this->session->set_flashdata('error', 'Opps Terjadi Kesalahan URL API');
            redirect(base_url("returns"));
        }
    }

    private function validateDataResult($data)
    {
        if (empty($data)) {
            $this->session->set_flashdata('error', 'Data Tidak Ada');
            redirect(base_url("returns"));
        }
    }
}
