<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Output $output
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

            if (!empty($input->barcode)) {
                $url = $this->config->item('base_url_api') . "/shelves/$input->barcode";
                $apiKey = $this->config->item('api_key');
                $responseRak = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
                $resultRak = json_decode($responseRak);


                $this->validateResponse($responseRak, "home");
                $this->validateDataResult($resultRak->data->shelf);
                $idRak = $resultRak->data->shelf->idRak;
                $rak = $resultRak->data->shelf->rak;

                redirect(base_url("returns/detail/$idRak/$rak"));
            }

            $url = $this->config->item('base_url_api') . "/returns";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            $this->validateResponse($result, "home");

            $data['content'] = isset($result->data->returns) ? $result->data->returns : [];
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Retur: ' . $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Data Returns';
        $data['nav'] = 'Retur - Scan Rak';
        $data['field'] = 'Rak';
        $data['input'] = $this->defalutValueReturns();
        $data['form_action'] = "returns";
        $data['page'] = 'pages/retur/index';
        $this->view($data);
    }


    public function detail($idRak, $rak)
    {
        try {
            $response = $this->handleGetDataReturns($idRak);

            $this->validateResponse($response, "home");

            $data['idRak'] = $idRak;
            $data['rak'] = $rak;
            $data['content'] = $response->data->returns;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Retur: ' . $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Detail Returns';
        $data['nav'] = 'Retur - Scan Rak';
        $data['page'] = 'pages/retur/detail';
        $this->view($data);
    }

    public function save()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->validateInput($data);
            $data['user'] = $this->session->userdata('username');
            $saveBarcode = $this->returns->saveBarcodeAPI($data);

            if ($saveBarcode->status == 'fail') {
                throw new Exception($saveBarcode->message);
            }
            $response = $this->handleGetDataReturns($data['idRak']);
            $this->sendJsonResponse($response);
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Retur: ' . $e->getMessage());
            $this->sendJsonResponse(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function handleGetDataReturns($idRak)
    {
        $url = $this->config->item('base_url_api') . "/returns/$idRak";
        $apiKey = $this->config->item('api_key');
        $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
        $result = json_decode($response);
        return $result;
    }

    private function defalutValueReturns()
    {

        return (object) $this->returns->getDefaultValues();
    }

    private function validateResponse($response, $url)
    {

        if ($response == NULL || !empty($response->statusCode) || isset($response->statusCode)) {
            $this->session->set_flashdata('error', 'Opps Server API Error');
            redirect(base_url($url));
        }
    }

    private function validateDataResult($data)
    {
        if (empty($data)) {
            $this->session->set_flashdata('error', 'Data Tidak Ada');
            redirect(base_url("returns"));
        }
    }

    private function validateInput($data)
    {
        $requiredFields = ['barcode'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Field $field tidak boleh kosong");
            }
        }
    }

    private function sendJsonResponse($response)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
