<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property PickerSo_model $pickerso
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
            $url = $this->config->item('base_url_api') . "/returns";
            $apiKey = $this->config->item('api_key');
            $response = curl_request($url, 'GET', null, ["X-API-KEY: $apiKey"]);
            $result = json_decode($response);

            if (!$result || !isset($result->data->returns)) {
                throw new Exception('Data Retur tidak valid');
            }

            $data['content'] = $result->data->returns;
        } catch (Exception $e) {
            log_message('error', 'Error saat mengambil data Retur: ' . $e->getMessage());
            $data['content'] = [];
        }

        $data['title'] = 'Form Returns';
        $data['nav'] = 'Retur - Scan Rak';
        $data['page'] = 'pages/retur/index';
        $this->view($data);
    }
}
